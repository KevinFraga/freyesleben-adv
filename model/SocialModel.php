<?php
require_once('model/database.php');
require_once('middleware/PHPMailer/PHPMailer.php');
require_once('middleware/PHPMailer/Exception.php');
require_once('middleware/PHPMailer/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

class SocialModel
{
  public function contactUs(string $name, string $email, string $subject, string $text)
  {
    global $smtpEmail, $smtpName, $stmpPassword;
    $email_subject = "Cliente: $name ($email) - Assunto: {$subject}";

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

    $mail->addAddress($smtpEmail);
    $mail->addReplyTo($email);

    $mail->Subject = $email_subject;
    $mail->Body = $text;

    if (!$mail->send()) {
      return 'Problemas com o envio do email: ' . $mail->ErrorInfo;
    }
    return 'Email enviado com sucesso';
  }
  public function receipt(string $name, string $email, string $subject, string $text, array $file)
  {
    global $smtpEmail, $smtpName, $stmpPassword;
    $email_subject = $subject;

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

    $mail->Subject = $email_subject;
    $mail->Body = $text;

    $attachmentPath = $file['tmp_name'];
    $mail->addAttachment($attachmentPath, $file['name']);

    if (!$mail->send()) {
      return 'Problemas com o envio do email: ' . $mail->ErrorInfo;
    }
    return 'Email enviado com sucesso';
  }
  public function newPartner(string $name, string $description)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO Mandark (partner, description) VALUES (?, ?);");
    mysqli_stmt_bind_param($query, 'ss', $name, $description);
    
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    mysqli_close($connect);
    return 'Parceiro adicionado com sucesso';
  }
  public function deletePartner(int $id)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $query2 = mysqli_prepare($connect, "SELECT logo FROM Mandark WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $id);
    mysqli_stmt_execute($query2);
    mysqli_stmt_bind_result($query2, $logo);

    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    $logoPath = "{$_SERVER['DOCUMENT_ROOT']}$logo";
    $oldPic = 'view/images/new-user.png';
    
    if (file_exists($logoPath) && $logo != $oldPic) {
      unlink($logoPath);
    }

    $query = mysqli_prepare($connect, "DELETE FROM Mandark WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
  }
  public function partnerNewLogo(int $id, string $logo, string $tmp_name)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT partner FROM Mandark WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $extension = strtolower(pathinfo($logo, PATHINFO_EXTENSION));
    $path = "{$_SERVER['DOCUMENT_ROOT']}uploads/{$name}-logo.{$extension}";
    $img = "uploads/{$name}-logo.{$extension}";
    
    if (!move_uploaded_file($tmp_name, $path)) {
      mysqli_close($connect);
      return 'Erro ao enviar o arquivo';
    }
    
    $query2 = mysqli_prepare($connect, "UPDATE Mandark SET logo = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'si', $img, $id);
    mysqli_stmt_execute($query2);
    mysqli_stmt_close($query2);

    mysqli_close($connect);
    return 'Logo atualizada com sucesso';
  }
  public function partnerOldLogo(int $id)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT logo FROM Mandark WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $newLogo);

    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $logo = "{$_SERVER['DOCUMENT_ROOT']}$newLogo";
    $oldPic = 'view/images/new-user.png';
    
    if (file_exists($logo) && $newLogo != $oldPic) {
      unlink($logo);
    }

    $query2 = mysqli_prepare($connect, "UPDATE Mandark SET logo = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'si', $oldPic, $id);
    mysqli_stmt_execute($query2);

    mysqli_close($connect);
  }
  public function partnerEdit(int $id, string $name, string $description)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "UPDATE Mandark SET partner = ?, description = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'ssi', $name, $description, $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Parceiro atualizado com sucesso';
  }
  public function newVideo(string $title, string $url)
  {
    global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
    $connect = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO SpaceGhost (title, video) VALUES (?, ?);");
    mysqli_stmt_bind_param($query, 'ss', $title, $url);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Vídeo adicionado com sucesso';
  }
  public function selectVideo(int $id)
  {
    global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
    $connect = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
    $connect->set_charset('utf8');

    mysqli_query($connect, "UPDATE SpaceGhost SET selected = FALSE WHERE selected = TRUE;");
    
    $query = mysqli_prepare($connect, "UPDATE SpaceGhost SET selected = TRUE WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Vídeo selecionado com sucesso';
  }
}
