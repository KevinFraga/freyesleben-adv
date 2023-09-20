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

class ProcessModel
{
  public function newProcess(int $user_id, int $type_id)
  {
    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "INSERT INTO Mandy (user_id, process_type_id) VALUES (?, ?);");
    mysqli_stmt_bind_param($query, 'ii', $user_id, $type_id);
    mysqli_stmt_execute($query);

    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Processo criado com sucesso';
  }
  public function fileUpload(string $tmp_name, string $extension, int $user, int $process, int $file_type)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');
    
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect2 = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect2->set_charset('utf8');

    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect3 = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect3->set_charset('utf8');

    global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
    $connect4 = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
    $connect4->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT type, contract FROM Eustace WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $file_type);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_bind_result($query, $type, $is_contract);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (!isset($type)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      mysqli_close($connect3);
      mysqli_close($connect4);
      return 'Tipo de documento inválido';
    }

    $query2 = mysqli_prepare($connect2, "SELECT name FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $user);
    mysqli_stmt_execute($query2);

    mysqli_stmt_bind_result($query2, $full_name);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

    if (!isset($full_name)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      mysqli_close($connect3);
      mysqli_close($connect4);
      return 'Usuário inválido';
    }

    $token = strtok($full_name, ' ');
    $first_name = $token;

    while ($token) {
      $last_name = $token;
      $token = strtok(' ');
    }

    $client = "$first_name $last_name";

    $query3 = mysqli_prepare($connect3, "SELECT b.type FROM Billy b INNER JOIN Mandy m ON b.id = m.process_type_id WHERE m.id = ?;");
    mysqli_stmt_bind_param($query3, 'i', $process);
    mysqli_stmt_execute($query3);
    
    mysqli_stmt_bind_result($query3, $process_name);
    mysqli_stmt_fetch($query3);
    mysqli_stmt_close($query3);

    if (!isset($process_name)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      mysqli_close($connect3);
      mysqli_close($connect4);
      return 'Processo inválido';
    }

    $file_name = "$client - $type - $process_name - $process.enc";
    $path = "{$_SERVER['DOCUMENT_ROOT']}uploads/$file_name";
    $size = filesize($tmp_name);
    
    $keyGen = Key::createNewRandomKey();

    $key = $keyGen->saveToAsciiSafeString();

    $fileEncrytor = new File();

    $fileEncrytor->encryptFile($tmp_name, $path, $keyGen);
    
    if (!file_exists($path) || !is_readable($path)) {
      mysqli_close($connect);
      mysqli_close($connect2);
      mysqli_close($connect3);
      mysqli_close($connect4);
      return 'Erro ao enviar o arquivo';
    }
    
    $query4 = mysqli_prepare($connect, "INSERT INTO Courage (user_id, process_id, file_type_id, name, path, extension, size) VALUES (?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($query4, 'iiisssi', $user, $process, $file_type, $file_name, $path, $extension, $size);
    mysqli_stmt_execute($query4);
    
    $file_id = mysqli_insert_id($connect);
    mysqli_stmt_close($query4);
    
    $query5 = mysqli_prepare($connect, "SELECT COUNT(CASE WHEN e.contract THEN c.id END) AS contract, COUNT(CASE WHEN NOT e.contract THEN c.id END) AS document FROM Courage c INNER JOIN Eustace e ON c.file_type_id = e.id WHERE c.process_id = ?;");
    mysqli_stmt_bind_param($query5, 'i', $process);
    mysqli_stmt_execute($query5);

    mysqli_stmt_bind_result($query5, $con_received, $doc_received);
    mysqli_stmt_fetch($query5);
    mysqli_stmt_close($query5);
    
    $query6 = mysqli_prepare($connect3, "UPDATE Mandy SET contracts_received = ?, documents_received = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query6, 'iii', $con_received, $doc_received, $process);
    mysqli_stmt_execute($query6);
    mysqli_stmt_close($query6);
    
    $query7 = mysqli_prepare($connect4, "INSERT INTO Dexter (file_id, encrypt_key) VALUES (?, ?);");
    mysqli_stmt_bind_param($query7, 'is', $file_id, $key);
    mysqli_stmt_execute($query7);
    mysqli_stmt_close($query7);
    
    mysqli_close($connect);
    mysqli_close($connect2);
    mysqli_close($connect3);
    mysqli_close($connect4);
    return 'Documento recebido com sucesso';
  }
  public function fileDelete(int $user, int $process, int $file_type)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect2 = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect2->set_charset('utf8');

    global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
    $connect3 = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
    $connect3->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT c.id, c.path, e.contract FROM Courage c INNER JOIN Eustace e ON c.file_type_id = e.id WHERE c.user_id = ? AND c.process_id = ? AND c.file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'iii', $user, $process, $file_type);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_bind_result($query, $id, $path, $is_contract);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if (file_exists($path)) {
      unlink($path);
    }

    $query2 = mysqli_prepare($connect, "DELETE FROM Courage WHERE id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $id);
    mysqli_stmt_execute($query2);
    mysqli_stmt_close($query2);

    $query3 = mysqli_prepare($connect, "SELECT COUNT(CASE WHEN e.contract THEN c.id END) AS contract, COUNT(CASE WHEN NOT e.contract THEN c.id END) AS document FROM Courage c INNER JOIN Eustace e ON c.file_type_id = e.id WHERE c.process_id = ?;");
    mysqli_stmt_bind_param($query3, 'i', $process);
    mysqli_stmt_execute($query3);

    mysqli_stmt_bind_result($query3, $con_received, $doc_received);
    mysqli_stmt_fetch($query3);
    mysqli_stmt_close($query3);

    $query4 = mysqli_prepare($connect2, "UPDATE Mandy SET contracts_received = ?, documents_received = ? WHERE id = ?;");
    mysqli_stmt_bind_param($query4, 'iii', $con_received, $doc_received, $process);
    mysqli_stmt_execute($query4);
    mysqli_stmt_close($query4);

    $query5 = mysqli_prepare($connect3, "DELETE FROM Dexter WHERE file_id = ?;");
    mysqli_stmt_bind_param($query5, 'i', $id);
    mysqli_stmt_execute($query5);
    mysqli_stmt_close($query5);

    mysqli_close($connect);
    mysqli_close($connect2);
    mysqli_close($connect3);
    return 'Documento deletado com sucesso';
  }
  public function downloadContract(int $file_type_id)
  {
    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect->set_charset('utf8');

    $query = mysqli_prepare($connect, "SELECT m.path, m.extension, m.size, e.type FROM Muriel m INNER JOIN Eustace e ON m.file_type_id = e.id WHERE m.file_type_id = ?;");
    mysqli_stmt_bind_param($query, 'i', $file_type_id);
    mysqli_stmt_execute($query);

    mysqli_stmt_bind_result($query, $path, $ext, $size, $type);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    mysqli_close($connect);
    $answer = ['path' => $path, 'ext' => $ext, 'size' => $size, 'type' => $type];
    return $answer;
  }
  public function processFinishedEmail(int $user_id, int $process_id)
  {
    global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
    $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
    $connect->set_charset('utf8');

    global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
    $connect2 = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
    $connect2->set_charset('utf8');

    global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
    $connect3 = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
    $connect3->set_charset('utf8');

    global $smtpEmail, $smtpName, $stmpPassword;

    $query = mysqli_prepare($connect, "SELECT email, name FROM Chowder WHERE id = ?;");
    mysqli_stmt_bind_param($query, 'i', $user_id);
    mysqli_execute($query);

    mysqli_stmt_bind_result($query, $user_email, $user_name);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    $query2 = mysqli_prepare($connect2, "SELECT b.type FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ?;");
    mysqli_stmt_bind_param($query2, 'i', $process_id);
    mysqli_execute($query2);

    mysqli_stmt_bind_result($query2, $process);
    mysqli_stmt_fetch($query2);
    mysqli_stmt_close($query2);

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
    $mail->addCC($smtpEmail);
    $mail->isHTML(true);

    $email_subject = "Freyesleben Advogados - Processo Iniciado - $process";
    $text = "<h1>Olá, $user_name</h1><h2>Você completou a primeira etapa de abertura de processo.</h2><h3>Foram recebidos os seguintes documentos:</h3><ul>";
    $alt_text = "Olá, $user_name\n\nVocê completou a primeira etapa de abertura de processo.\nForam recebidos os seguintes documentos:\n";

    $query3 = mysqli_prepare($connect3, "SELECT e.type FROM Courage c INNER JOIN Eustace e ON c.file_type_id = e.id WHERE c.user_id = ? AND c.process_id = ? ORDER BY e.type;");
    mysqli_stmt_bind_param($query3, 'ii', $user_id, $process_id);

    mysqli_execute($query3);
    mysqli_stmt_bind_result($query3, $file);

    while (mysqli_stmt_fetch($query3)) {
      $text .= "<li>$file</li>";
      $alt_text .= "- $file\n";
    }

    mysqli_stmt_close($query3);

    $text .= "</ul><h2>Agradecemos a confiança depositada em nosso escritório e esperamos poder retribuir com o êxito.</h2>";
    $alt_text .= "Agradecemos a confiança depositada em nosso escritório e esperamos poder retribuir com o êxito.";

    $mail->Subject = $email_subject;
    $mail->Body = $text;
    $mail->AltBody = $alt_text;

    if (!$mail->send()) {
      mysqli_close($connect);
      mysqli_close($connect2);
      mysqli_close($connect3);
      return 'Problemas com o envio do e-mail de confirmação: ' . $mail->ErrorInfo;
    }

    $query4 = mysqli_prepare($connect2, "UPDATE Mandy SET email_sent = TRUE WHERE id = ?;");
    mysqli_stmt_bind_param($query4, 'i', $process_id);

    mysqli_execute($query4);
    mysqli_stmt_close($query4);

    mysqli_close($connect);
    mysqli_close($connect2);
    mysqli_close($connect3);
    return 'E-mail de confirmação enviado com sucesso';
  }
}
