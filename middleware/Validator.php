<?php
class Validator
{
  public function login(string $email, string $cpf, string $password, string $kind)
  {
    $email = htmlspecialchars($email);
    $cpf = htmlspecialchars($cpf);
    $password = htmlspecialchars($password);
    $kind = htmlspecialchars($kind);

    if ($kind == 'cpf') {
      $cpf = preg_replace('/[^0-9]/is', '', $cpf);
       
      if (strlen($cpf) != 11) {
        return 'O CPF deve conter exatamente 11 dígitos';
      }
  
      if (preg_match('/(\d)\1{10}/', $cpf)) {
        return 'CPF inválido';
      }
  
      for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
          return 'CPF inválido';
        }
      }
    }

    if ($kind == 'email') {
      $emailTest = preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $email);
      
      if (!$emailTest) {
        return 'Insira um e-mail válido';
      }
    }

    $passwordTest = preg_match('/^.{8,20}$/', $password);

    if (!$passwordTest) {
      return 'A senha deve conter entre 8 e 20 caracteres';
    }

    return 'válido';
  }
  public function newUser(string $new_user_name, string $new_user_email, string $new_user_email_confirm, string $new_user_password, string $new_user_password_confirm)
  {
    $new_user_name = htmlspecialchars($new_user_name);
    $new_user_email = htmlspecialchars($new_user_email);
    $new_user_email_confirm = htmlspecialchars($new_user_email_confirm);
    $new_user_password = htmlspecialchars($new_user_password);
    $new_user_password_confirm = htmlspecialchars($new_user_password_confirm);

    $nameTest = preg_match('/^\w[\w\-\ À-ü]{4,150}$/', $new_user_name);
    if (!$nameTest) {
      return 'Seu nome deve conter pelo menos 5 caracteres, sem espaços em branco antes das letras';
    }
    $emailTest = preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $new_user_email);
    if (!$emailTest) {
      return 'Insira um e-mail válido';
    }
    $emailConfirmTest = ($new_user_email_confirm === $new_user_email);
    if (!$emailConfirmTest) {
      return 'O e-mail de confirmação deve ser igual ao e-mail';
    }
    $passwordTest = preg_match('/^.{8,20}$/', $new_user_password);
    if (!$passwordTest) {
      return 'A senha deve ter entre 8 e 20 caracteres';
    }
    $passwordConfirmTest = ($new_user_password_confirm === $new_user_password);
    if (!$passwordConfirmTest) {
      return 'A confirmação deve ser igual à senha';
    }
    return 'válido';
  }
  public function emailTest(string $email)
  {
    $email = htmlspecialchars($email);

    $emailTest = preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $email);
    if (!$emailTest) {
      return 'Insira um e-mail válido';
    }

    return 'válido';
  }
  public function validateCPF(string $cpf)
  {
    $cpf = htmlspecialchars($cpf);
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
     
    if (strlen($cpf) != 11) {
      return 'O CPF deve conter exatamente 11 dígitos';
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
      return 'CPF inválido';
    }

    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
        return 'CPF inválido';
      }
    }
    return 'válido';
  }
  public function celTest(string $cel)
  {
    $cel = htmlspecialchars($cel);
    $cel = preg_replace('/[^0-9]/is', '', $cel);

    if (strlen($cel) < 7) {
      return 'O celular deve ter pelo menos 7 dígitos';
    }

    $celTest = preg_match('/^\d{7,20}/', $cel);
    if (!$celTest) {
      return 'O celular deve conter apenas números';
    }
    return 'válido';
  }
  public function idTest(string $id)
  {
    $id = htmlspecialchars($id);
    
    $idTest = preg_match('/^\d{1,11}$/', $id);
    if (!$idTest) {
      return 'Id inválido';
    }
    return 'válido';
  }
  public function typeTest(string $type)
  {
    $type = htmlspecialchars($type);

    $typeTest = preg_match('/[\w\-\ \\@À-ü\/.,!:;?()[\]{}]+/', $type);
    if (!$typeTest) {
      return '< e > são caracteres proibidos';
    }
    return 'válido';
  }
  public function newNecessaryFile(string $process_type, string $file_type)
  {
    $process_type = htmlspecialchars($process_type);
    $file_type = htmlspecialchars($file_type);

    $processTest = preg_match('/^\d{1,10}$/', $process_type);
    $fileTest = preg_match('/^\d{1,10}$/', $file_type);
    if (!$processTest || !$fileTest) {
      return 'Erro na operação';
    }
    return 'válido';
  }
  public function email(string $name, string $email, string $subject, string $text)
  {
    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $subject = htmlspecialchars($subject);
    $text = htmlspecialchars($text);

    $nameTest = preg_match('/^[\w\-\ À-ü]{3,150}$/', $name);
    if (!$nameTest) {
      return 'Seu nome deve conter pelo menos 3 caracteres';
    }
    $emailTest = preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $email);
    if (!$emailTest) {
      return 'Insira um e-mail válido';
    }
    $subjectTest = preg_match('/^[\w\-\ \\@À-ü\/.,!:;?()[\]{}]{5,250}$/', $subject);
    if (!$subjectTest) {
      return 'O assunto deve conter de 5 a 250 caracteres';
    }
    $textTest = preg_match('/[\w\-\ \\@À-ü\/.,!:;?()[\]{}]+/', $text);
    if (!$textTest) {
      return '< e > são caracteres proibidos';
    }
    return 'válido';
  }
  public function confirmToken(string $id, string $token)
  {
    $id = htmlspecialchars($id);
    $token = htmlspecialchars($token);

    $idTest = preg_match('/^\d{1,10}$/', $id);
    if (!$idTest) {
      return 'Id de usuário inválido';
    }

    $tokenTest = preg_match('/^\$2y\$.{56}$/', $token);
    if (!$tokenTest) {
      return 'Token de confirmação inválido';
    }

    return 'válido';
  }
  public function fileUpload(array $file, string $user, string $process, string $file_type)
  {
    $user = htmlspecialchars($user);
    $process = htmlspecialchars($process);
    $file_type = htmlspecialchars($file_type);

    $userTest = preg_match('/^\d{1,10}$/', $user);
    $processTest = preg_match('/^\d{1,10}$/', $process);
    $fileTypeTest = preg_match('/^\d{1,10}$/', $file_type);
    if (!$userTest || !$processTest || !$fileTypeTest) {
      return 'Erro na operação';
    }

    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($file_extension != 'pdf') {
      return 'Documento não é um pdf';
    }
    $max_size = 5 * 1024 * 1024;
    if ($file['size'] > $max_size) {
      return 'Documento maior que 5MB';
    }
    if ($file['error'] != UPLOAD_ERR_OK) {
      return "Erro: {$file['error']}";
    }

    return 'válido';
  }
  public function fileDelete(string $user, string $process, string $file_type)
  {
    $user = htmlspecialchars($user);
    $process = htmlspecialchars($process);
    $file_type = htmlspecialchars($file_type);

    $userTest = preg_match('/^\d{1,10}$/', $user);
    $processTest = preg_match('/^\d{1,10}$/', $process);
    $fileTypeTest = preg_match('/^\d{1,10}$/', $file_type);
    if (!$userTest || !$processTest || !$fileTypeTest) {
      return 'Erro na operação';
    }

    return 'válido';
  }
  public function typeUpdate(string $type, string $id)
  {
    $type = htmlspecialchars($type);
    $id = htmlspecialchars($id);

    $typeTest = preg_match('/[\w\-\ \\@À-ü\/.,!:;?()[\]{}]+/', $type);
    if (!$typeTest) {
      return '< e > são caracteres proibidos';
    }
    $idTest = preg_match('/^\d{1,10}$/', $id);
    if (!$idTest) {
      return 'Id inválido';
    }

    return 'válido';
  }
  public function avatar(array $avatar)
  {
    $file_extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
    $allowed_extensions = array('jpg', 'jpeg', 'png');

    if (!in_array($file_extension, $allowed_extensions)) {
      return 'Documento não é jpg, jpeg ou png';
    }
    $max_size = 5 * 1024 * 1024;
    if ($avatar['size'] > $max_size) {
      return 'Documento maior que 5MB';
    }
    if ($avatar['error'] != UPLOAD_ERR_OK) {
      return "Erro: {$avatar['error']}";
    }

    return 'válido';
  }
  public function newPassword(string $password, string $password_confirm, string $user)
  {
    $password = htmlspecialchars($password);
    $password_confirm = htmlspecialchars($password_confirm);
    $user = htmlspecialchars($user);

    $passwordTest = preg_match('/^.{8,20}$/', $password);
    if (!$passwordTest) {
      return 'A senha deve ter entre 8 e 20 caracteres';
    }
    $passwordConfirmTest = ($password_confirm === $password);
    if (!$passwordConfirmTest) {
      return 'A confirmação deve ser igual à senha';
    }
    $idTest = preg_match('/^\d{1,10}$/', $user);
    if (!$idTest) {
      return 'Id do usuário inválido';
    }

    return 'válido';
  }
  public function contractFile(array $file)
  {
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = array('doc', 'docx', 'pdf');

    if (!in_array($file_extension, $allowed_extensions)) {
      return 'Documento não é doc, docx ou pdf';
    }
    $max_size = 5 * 1024 * 1024;
    if ($file['size'] > $max_size) {
      return 'Documento maior que 5MB';
    }
    if ($file['error'] != UPLOAD_ERR_OK) {
      return "Erro: {$file['error']}";
    }

    return 'válido';
  }
}
