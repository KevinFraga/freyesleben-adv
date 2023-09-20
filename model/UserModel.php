<?php
require_once('middleware/session.php');
require_once('model/database.php');
require_once('middleware/PHPMailer/PHPMailer.php');
require_once('middleware/PHPMailer/Exception.php');
require_once('middleware/PHPMailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

class UserModel
{
  public function getUser(string $email, string $cpf, string $password, string $kind)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    if ($kind === 'email') {
      $q = "SELECT id, name, avatar, kind, password, email_confirmed FROM Chowder WHERE email = ?;";
      $p = $email;
    }

    if ($kind === 'cpf') {
      $q = "SELECT id, name, avatar, kind, password, email_confirmed FROM Chowder WHERE cpf = ?;";
      $p = $cpf;
    }
    
    $query = mysqli_prepare($connect, $q);
    mysqli_stmt_bind_param($query, 's', $p);
    
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $id, $name, $avatar, $kind, $hashed, $confirmed);
    
    if (!mysqli_stmt_fetch($query)) {
      mysqli_stmt_close($query);
      mysqli_close($connect);
      return 'Usuário não encontrado';
    }

    mysqli_stmt_close($query);
    mysqli_close($connect);

    $verify = password_verify($password, $hashed);
    if (!$verify) {
      return 'Senha incorreta';
    }

    if (!$confirmed) {
      return 'E-mail ainda não confirmado';
    }
    
    $_SESSION['user_id'] = $id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_avatar'] = "/$avatar";
    $_SESSION['user_kind'] = $kind;

    return 'Usuário encontrado com sucesso';
  }
  public function registerUser(string $name, string $email, string $cel, string $cpf, string $password)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $new_user_password = password_hash($password, PASSWORD_DEFAULT);
    $confirmation_token = password_hash('confirm_email', PASSWORD_BCRYPT);

    $query = mysqli_prepare($connect, "INSERT INTO Chowder (name, email, cellphone, cpf, password, confirmation_token) VALUES (?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($query, 'ssssss', $name, $email, $cel, $cpf, $new_user_password, $confirmation_token);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_close($query);
    mysqli_close($connect);
  }
  public function checkAlreadyUser(string $email, string $cpf)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT id FROM Chowder WHERE email = ?;");
    mysqli_stmt_bind_param($query, 's', $email);
    
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $id);

    if (mysqli_stmt_fetch($query)) {
      mysqli_stmt_close($query);
      mysqli_close($connect);
      return 'Email já cadastrado';
    }

    mysqli_stmt_close($query);

    $query2 = mysqli_prepare($connect, "SELECT id FROM Chowder WHERE cpf = ?;");
    mysqli_stmt_bind_param($query2, 's', $cpf);
    mysqli_stmt_execute($query2);

    if (mysqli_stmt_fetch($query2)) {
      mysqli_stmt_close($query2);
      mysqli_close($connect);
      return 'CPF já cadastrado';
    }

    mysqli_stmt_close($query2);
    mysqli_close($connect);
    return 'válido';
  }
  public function confirmationEmail(string $user_email)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A, $smtpEmail, $smtpName, $stmpPassword;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT id, name, confirmation_token FROM Chowder WHERE email = ?;");
    mysqli_stmt_bind_param($query, 's', $user_email);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $user_id, $user_name, $user_token);
    mysqli_stmt_fetch($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);

    $mail = new PHPMailer;
    $mail->setLanguage("br");
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'email-ssl.com.br';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->Username = $smtpEmail;
    $mail->Password = $stmpPassword;
    $mail->From = $smtpEmail;
    $mail->FromName = $smtpName;

    $mail->addAddress($user_email);
    $mail->addReplyTo($smtpEmail);
    $mail->isHTML(true);

    $email_subject = "Freyesleben Advogados - Confirmação de email";
    $confirm_link = "https://freyesleben.adv.br/confirmacao?id=$user_id&token=$user_token";
    $text = "<h1>Olá, $user_name</h1><br/><h2>Muito obrigado por se cadastrar conosco.<br/>Para confirmar seu cadastro, por favor clique no <a href=$confirm_link>link</a>.</h2>";
    $alt_text = "Olá, $user_name\n\nMuito obrigado por se cadastrar conosco.\nPara confirmar seu cadastro, por favor clique no link:\n$confirm_link";

    $mail->Subject = $email_subject;
    $mail->Body = $text;
    $mail->AltBody = $alt_text;

    if (!$mail->send()) {
      return 'Problemas com o envio do e-mail de confirmação: ' . $mail->ErrorInfo;
    }
    return 'E-mail de confirmação enviado com sucesso';
  }
  public function confirmUser(int $id, string $token)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT confirmation_token FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $confirmation_token);

    if (!mysqli_stmt_fetch($query)) {
      mysqli_stmt_close($query);
      mysqli_close($connect);
      return 'Usuário não cadastrado';
    }

    mysqli_stmt_close($query);
    
    if ($token == $confirmation_token) {
      $query2 = mysqli_prepare($connect, "UPDATE Chowder SET email_confirmed = TRUE WHERE id = ?;");
      mysqli_stmt_bind_param($query2, 'i', $id);
      mysqli_stmt_execute($query2);

      mysqli_stmt_close($query2);
      mysqli_close($connect);
      return 'Usuário confirmado com sucesso';
    }

    mysqli_close($connect);
    return 'Token de confirmação incorreto';
  }
  public function newAvatar(string $newPic, string $tmp_name, int $user)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');
    
    $query = mysqli_prepare($connect, "SELECT name FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $user);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $full_name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $token = strtok($full_name, ' ');
    $first_name = $token;

    while ($token) {
      $last_name = $token;
      $token = strtok(' ');
    }

    $client = "$first_name $last_name";

    $extension = strtolower(pathinfo($newPic, PATHINFO_EXTENSION));
    $path = "{$_SERVER['DOCUMENT_ROOT']}uploads/{$client}-avatar.{$extension}";
    $avatar = "uploads/{$client}-avatar.{$extension}";
    
    if (!move_uploaded_file($tmp_name, $path)) {
      mysqli_close($connect);
      return 'Erro ao enviar o arquivo';
    }

    $query2 = mysqli_prepare($connect, "UPDATE Chowder SET avatar = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'si', $avatar, $user);
    mysqli_stmt_execute($query2);
    mysqli_stmt_close($query2);
    
    mysqli_close($connect);
    $_SESSION['user_avatar'] = "/$avatar";
    return 'Foto de Perfil atualizada com sucesso';
  }
  public function oldAvatar(int $user)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT avatar FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $user);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $newPic);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $pic = "{$_SERVER['DOCUMENT_ROOT']}$newPic";
    $oldPic = 'view/images/new-user.png';
    $oldPicAddress = "{$_SERVER['DOCUMENT_ROOT']}$oldPic";
    
    if (file_exists($pic) && $pic != $oldPicAddress) {
      unlink($pic);
    }
    
    $query2 = mysqli_prepare($connect, "UPDATE Chowder SET avatar = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'si', $oldPic, $user);
    mysqli_stmt_execute($query2);
    mysqli_stmt_close($query2);
    
    mysqli_close($connect);
    $_SESSION['user_avatar'] = "/$oldPic";
    return 'Foto de Perfil removida com sucesso';
  }
  public function editEmail(string $email, int $id)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query2 = mysqli_prepare($connect, "SELECT email FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $id);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $oldEmail);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    if ($oldEmail == $email) {
      return "Esse email já consta no seu cadastro";
    }

    $query3 = mysqli_prepare($connect, "SELECT id FROM Chowder WHERE email = ?;");
    mysqli_stmt_bind_param($query3, 's', $email);
    mysqli_stmt_execute($query3);

    mysqli_stmt_bind_result($query3, $emailOwner);
    mysqli_stmt_fetch($query3);
    mysqli_stmt_close($query3);

    if (isset($emailOwner)) {
      return "Esse email já está sendo utilizado por outro usuário";
    }

    $query = mysqli_prepare($connect, "UPDATE Chowder SET email = ?, email_confirmed = FALSE WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'si', $email, $id);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    mysqli_close($connect);
    return 'Email atualizado com sucesso';
  }
  public function editInfo(string $name, int $cel, int $cpf, int $id)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "UPDATE Chowder SET name = ?, cellphone = ?, cpf = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'siii', $name, $cel, $cpf, $id);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    mysqli_close($connect);
    return 'Informações atualizadas com sucesso';
  }
  public function lostPassword(string $email, string $cpf)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A, $smtpEmail, $smtpName, $stmpPassword;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT id, name, confirmation_token FROM Chowder WHERE email = ? AND cpf = ?;");
    mysqli_stmt_bind_param($query, 'ss', $email, $cpf);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $id, $name, $token);
    
    if (!mysqli_stmt_fetch($query)) {
      mysqli_stmt_close($query);
      mysqli_close($connect);
      return 'Usuário não encontrado';
    }

    mysqli_stmt_close($query);
    mysqli_close($connect);
    
    $mail = new PHPMailer;
    $mail->setLanguage("br");
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'email-ssl.com.br';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->Username = $smtpEmail;
    $mail->Password = $stmpPassword;
    $mail->From = $smtpEmail;
    $mail->FromName = $smtpName;

    $mail->addAddress($email);
    $mail->addReplyTo($smtpEmail);
    $mail->isHTML(true);

    $email_subject = "Freyesleben Advogados - Alteração de senha";
    $confirm_link = "https://freyesleben.adv.br/senha?id=$id&token=$token";
    $text = "<h1>Olá, $name</h1><br/><h2>Sinto muito que tenha perdido sua senha.<br/>Para cadastrar uma nova, por favor clique no <a href=$confirm_link>link</a>.</h2>";
    $alt_text = "Olá, $name\n\nSinto muito que tenha perdido sua senha.\nPara cadastrar uma nova, por favor clique no link:\n$confirm_link";

    $mail->Subject = $email_subject;
    $mail->Body = $text;
    $mail->AltBody = $alt_text;

    if (!$mail->send()) {
      return 'Problemas com o envio do email: ' . $mail->ErrorInfo;
    }
    return 'Email enviado com sucesso';
  }
  public function newPassword(string $new_password, int $user)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $password = password_hash($new_password, PASSWORD_DEFAULT);
    $query = mysqli_prepare($connect, "UPDATE Chowder SET password = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'si', $password, $user);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Password atualizado com sucesso';
  }
}
