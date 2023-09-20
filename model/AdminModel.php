<?php
require_once('model/database.php');
require_once('middleware/PHPMailer/PHPMailer.php');
require_once('middleware/PHPMailer/Exception.php');
require_once('middleware/PHPMailer/SMTP.php');
require_once('middleware/php-encryption/Core.php');
require_once('middleware/php-encryption/File.php');
require_once('middleware/php-encryption/Key.php');
require_once('middleware/php-encryption/Encoding.php');
require_once('middleware/php-encryption/DerivedKeys.php');
require_once('middleware/php-encryption/KeyOrPassword.php');

use PHPMailer\PHPMailer\PHPMailer;
use Defuse\Crypto\File;
use Defuse\Crypto\Key;

class AdminModel
{
  public function newFileType(string $file_type, bool $is_contract)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');
    
    $query = mysqli_prepare($connect, "INSERT INTO Eustace (type, contract) VALUES (?, ?);");
    mysqli_stmt_bind_param($query, 'si', $file_type, $is_contract);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Documentação criada com sucesso';
  }
  public function updateFileType(string $type, int $id)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "UPDATE Eustace SET type = ? WHERE id = ?");
    mysqli_stmt_bind_param($query, 'si', $type, $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Documento renomeado com sucesso';
  }
  public function newProcessType(string $process_type)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO Billy (type) VALUES (?);");
    mysqli_stmt_bind_param($query, 's', $process_type);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Processo criado com sucesso';
  }
  public function updateProcessType(string $type, int $id)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "UPDATE Billy SET type = ? WHERE id = ?");
    mysqli_stmt_bind_param($query, 'si', $type, $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Processo renomeado com sucesso';
  }
  public function newNecessaryFile(int $process_type, int $file_type)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect2 = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect2->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO Grim (process_type_id, file_type_id) VALUES (?, ?);");
    mysqli_stmt_bind_param($query, 'ii', $process_type, $file_type);
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    $query2 = mysqli_prepare($connect2, "SELECT contract FROM Eustace WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $file_type);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $is_contract);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    $query3 = mysqli_prepare($connect, "SELECT documents_needed, contracts_needed FROM Billy WHERE id = ?;");
    mysqli_stmt_bind_param($query3, 'i', $process_type);
    mysqli_stmt_execute($query3);

    mysqli_stmt_bind_result($query3, $doc_needed, $con_needed);
    mysqli_stmt_fetch($query3);
    mysqli_stmt_close($query3);

    $new = $is_contract ? $con_needed + 1 : $doc_needed + 1;
    $q = $is_contract ? "UPDATE Billy SET contracts_needed = ? WHERE id = ?;" : "UPDATE Billy SET documents_needed = ? WHERE id = ?;";
    
    $query4 = mysqli_prepare($connect, $q);
    mysqli_stmt_bind_param($query4, 'ii', $new, $process_type);
    mysqli_stmt_execute($query4);
    mysqli_stmt_close($query4);

    mysqli_close($connect);
    mysqli_close($connect2);
    return 'Operação executada com sucesso';
  }
  public function checkAlreadyNecessaryFile(int $process_type, int $file_type)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT file_type_id FROM Grim WHERE process_type_id = ? AND file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'ii', $process_type, $file_type);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $file);
    mysqli_stmt_fetch($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);

    if (isset($file)) {
      return 'Esse documento já foi adicionado no processo';
    }

    return 'válido';
  }
  public function deleteNecessaryFile(int $process_type, int $file_type)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect2 = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect2->set_charset('utf8');

    $query = mysqli_prepare($connect, "DELETE FROM Grim WHERE process_type_id = ? AND file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'ii', $process_type, $file_type);
    
    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    $query2 = mysqli_prepare($connect2, "SELECT contract FROM Eustace WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $file_type);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $is_contract);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    $query3 = mysqli_prepare($connect, "SELECT documents_needed, contracts_needed FROM Billy WHERE id = ?;");
    mysqli_stmt_bind_param($query3, 'i', $process_type);
    mysqli_stmt_execute($query3);

    mysqli_stmt_bind_result($query3, $doc_needed, $con_needed);
    mysqli_stmt_fetch($query3);
    mysqli_stmt_close($query3);

    $new = $is_contract ? $con_needed - 1 : $doc_needed - 1;
    $q = $is_contract ? "UPDATE Billy SET contracts_needed = ? WHERE id = ?;" : "UPDATE Billy SET documents_needed = ? WHERE id = ?;";
    
    $query4 = mysqli_prepare($connect, $q);
    mysqli_stmt_bind_param($query4, 'ii', $new, $process_type);
    mysqli_stmt_execute($query4);

    mysqli_stmt_close($query4);
    mysqli_close($connect);
    mysqli_close($connect2);
  }
  public function newContract(string $file_name, string $tmp_name, string $extension, int $type)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT type FROM Eustace WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $type);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $fileType);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $name = "$fileType.$ext";
    $path = "{$_SERVER['DOCUMENT_ROOT']}uploads/$name";
    $size = filesize($tmp_name);

    if (!move_uploaded_file($tmp_name, $path)) {
      mysqli_close($connect);
      return 'Erro ao enviar o arquivo';
    }

    $query2 = mysqli_prepare($connect, "INSERT INTO Muriel (file_type_id, path, extension, size) VALUES (?, ?, ?, ?);");
    mysqli_stmt_bind_param($query2, 'issi', $type, $path, $extension, $size);
    mysqli_stmt_execute($query2);

    mysqli_stmt_close($query2);
    mysqli_close($connect);
    return 'Contrato adicionado com sucesso';
  }
  public function deleteContract(int $file_type_id)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT path FROM Muriel WHERE file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'i', $file_type_id);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $path);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (file_exists($path)) {
      unlink($path);
    }

    $query2 = mysqli_prepare($connect, "DELETE FROM Muriel WHERE file_type_id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $file_type_id);
    mysqli_stmt_execute($query2);

    mysqli_stmt_close($query2);
    mysqli_close($connect);
    return 'Contrato deletado com sucesso';
  }
  public function downloadClientFile(int $user, int $process, int $fileType)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
    $connect2 = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
    $connect2->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT id, name, path, extension, size FROM Courage WHERE user_id = ? AND process_id = ? AND file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'iii', $user, $process, $fileType);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $file_id, $file_name, $file_path, $ext, $size);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $query2 = mysqli_prepare($connect2, "SELECT encrypt_key FROM Dexter WHERE file_id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $file_id);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $key);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);
    
    mysqli_close($connect);
    mysqli_close($connect2);

    $keyGen = Key::loadFromAsciiSafeString($key, true);
    
    $decrypted_file = substr($file_name, 0, -4);
    $name = "$decrypted_file.pdf";

    $decrypted_path = substr($file_path, 0, -4);
    $path = "$decrypted_path.pdf";

    $fileEncrytor = new File();

    $fileEncrytor->decryptFile($file_path, $path, $keyGen);

    $answer = ['name' => $name, 'path' => $path, 'ext' => $ext, 'size' => $size];
    return $answer;
  }
  public function giveKind(int $id, string $kind)
  {
    if ($kind != 'adv' && $kind != 'ctd') {
      return 'Função inválida';
    }
    
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT name FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (!isset($name)) {
      mysqli_close($connect);
      return 'Usuário não encontrado';
    }

    $query2 = mysqli_prepare($connect, "UPDATE Chowder SET kind = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'si', $kind, $id);
    mysqli_stmt_execute($query2);
    
    mysqli_stmt_close($query2);
    mysqli_close($connect);

    return 'Usuário promovido com sucesso';
  }
  public function removeKind(int $id)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT name FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (!isset($name)) {
      mysqli_close($connect);
      return 'Usuário não encontrado';
    }

    $query2 = mysqli_prepare($connect, "UPDATE Chowder SET kind = 'usr' WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $id);
    mysqli_stmt_execute($query2);
    
    mysqli_stmt_close($query2);
    mysqli_close($connect);

    return 'Função do usuário removida com sucesso';
  }
  public function protocolNumber(int $user, int $process, string $protocol)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT process_type_id FROM Mandy WHERE id = ? AND user_id = ?;");
    mysqli_stmt_bind_param($query, 'ii', $process, $user);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $process_type);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (!isset($process_type)) {
      mysqli_close($connect);
      return 'Processo não encontrado';
    }

    $query2 = mysqli_prepare($connect, "UPDATE Mandy SET protocol_number = ? WHERE id = ? AND user_id = ? AND process_type_id = ?;");
    mysqli_stmt_bind_param($query2, 'siii', $protocol, $process, $user, $process_type);

    mysqli_stmt_execute($query2);
    mysqli_stmt_close($query2);

    mysqli_close($connect);
    return 'Processo atualizado com sucesso';
  }
  public function processStep(int $user, int $process, int $step)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect2 = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect2->set_charset('utf8');

    global $smtpEmail, $smtpName, $stmpPassword;

    $query = mysqli_prepare($connect, "SELECT m.process_type_id, b.type FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ? AND m.user_id = ?;");
    mysqli_stmt_bind_param($query, 'ii', $process, $user);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $process_type, $process_name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (!isset($process_type)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      return 'Processo não encontrado';
    }

    $query2 = mysqli_prepare($connect, "SELECT step FROM Irwin WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $step);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $step_name);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    if (!isset($step_name)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      return 'Estado não encontrado';
    }

    $query3 = mysqli_prepare($connect, "UPDATE Mandy SET step_id = ? WHERE id = ? AND user_id = ? AND process_type_id = ?;");
    mysqli_stmt_bind_param($query3, 'iiii', $step, $process, $user, $process_type);

    mysqli_stmt_execute($query3);
    mysqli_stmt_close($query3);

    $query4 = mysqli_prepare($connect2, "SELECT name, email FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query4, 'i', $user);
    mysqli_stmt_execute($query4);

    mysqli_stmt_bind_result($query4, $user_name, $user_email);
    mysqli_stmt_fetch($query4);
    mysqli_stmt_close($query4);

    mysqli_close($connect);
    mysqli_close($connect2);
    
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

    $email_subject = "Freyesleben Advogados - Atualização de Processo - $process_name";
    $text = "<h1>Olá, $user_name</h1><br/><h2>Seu processo foi atualizado, para acompanhá-lo entre na sua conta em nosso site.</h2>";
    $alt_text = "Olá, $user_name\n\nSeu processo foi atualizado, para acompanhá-lo entre na sua conta em nosso site.";

    $mail->Subject = $email_subject;
    $mail->Body = $text;
    $mail->AltBody = $alt_text;
    
    if (!$mail->send()) {
      return 'Problemas com o envio do e-mail: ' . $mail->ErrorInfo;
    }
    return 'Processo atualizado com sucesso, cliente notificado por e-mail';
  }
  public function newStep(string $step)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO Irwin (step) VALUES (?);");
    mysqli_stmt_bind_param($query, 's', $step);

    mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    mysqli_close($connect);
    return 'Estado adicionado com sucesso';
  }
  public function updateStep(string $step, int $id)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "UPDATE Irwin SET step = ? WHERE id = ?");
    mysqli_stmt_bind_param($query, 'si', $step, $id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Estado renomeado com sucesso';
  }
}
