<?php
require_once('middleware/session.php');
require_once('model/UserModel.php');
require_once('middleware/Validator.php');

class UserController
{
  public function home()
  {
    if (isset($_GET['logout'])) {
      setcookie(session_name(), '', 1, '/');
      session_destroy();
    }
    include('view/home.php');
  }
  public function login()
  {
    unset($error_locked);
    if (isset($_GET['logout']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
      setcookie(session_name(), '', 1, '/');
      session_destroy();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['lock']) || strlen($_POST['lock']) == 0) {
        $error_locked = 'Acesso não preenchido';
      } else {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['lock']);
        if ($valid == 'válido') {
          if ($_POST['lock'] == 'senha') {
            header("Location: https://freyesleben.adv.br/login/novo");
            exit;
          } else {
            $error_locked = 'Acesso incorreto';
          }
        }
      }
    }
    include('view/login.php');
  }
  public function loginOld()
  {
    unset($error_login);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['kind']) || ($_POST['kind'] != 'email' && $_POST['kind'] != 'cpf')) {
        $error_login = 'Login inválido';
      } else if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
        $error_login = 'Senha não preenchida';
      } else if ($_POST['kind'] == 'email' && (!isset($_POST['email']) || strlen($_POST['email']) == 0)) {
        $error_login = 'E-mail não preenchido';
      } else if ($_POST['kind'] == 'cpf' && (!isset($_POST['cpf']) || strlen($_POST['cpf']) == 0)) {
        $error_login = 'CPF não preenchido';
      } else {
        $validator = new Validator;
        $valid = $validator->login($_POST['email'], $_POST['cpf'], $_POST['password'], $_POST['kind']);
        if ($valid == 'válido') {
          $db = new UserModel;
          $error_login = $db->getUser($_POST['email'], $_POST['cpf'], $_POST['password'], $_POST['kind']);
          if ($error_login == 'Usuário encontrado com sucesso') {
            header("Location: https://freyesleben.adv.br/cliente?id={$_SESSION['user_id']}");
            exit;
          }
        } else {
          $error_login = $valid;
        }
      }
    }
    include('view/loginOld.php');
  }
  public function loginNew()
  {
    unset($error_new_user);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['new_user_name']) || strlen($_POST['new_user_name']) == 0) {
        $error_new_user = 'Nome não preenchido';
      } else if (!isset($_POST['new_user_email']) || strlen($_POST['new_user_email']) == 0) {
        $error_new_user = 'E-mail não preenchido';
      } else if (!isset($_POST['new_user_email_confirm']) || strlen($_POST['new_user_email_confirm']) == 0) {
        $error_new_user = 'Confirmação de e-mail não preenchido';
      } else if (!isset($_POST['new_user_cel']) || strlen($_POST['new_user_cel']) == 0) {
        $error_new_user = 'Celular não preenchido';
      } else if (!isset($_POST['new_user_cpf']) || strlen($_POST['new_user_cpf']) == 0) {
        $error_new_user = 'CPF não preenchido';
      } else if (!isset($_POST['new_user_password']) || strlen($_POST['new_user_password']) == 0) {
        $error_new_user = 'Senha não preenchida';
      } else if (!isset($_POST['new_user_password_confirm']) || strlen($_POST['new_user_password_confirm']) == 0) {
        $error_new_user = 'Confirmação de senha não preenchida';
      } else if (!isset($_POST['terms'])) {
        $error_new_user = 'Termos e condições não aceitos';
      } else {
        $validator = new Validator;
        $valid = $validator->newUser($_POST['new_user_name'], $_POST['new_user_email'], $_POST['new_user_email_confirm'], $_POST['new_user_password'], $_POST['new_user_password_confirm']);
        if ($valid == 'válido') {
          $valid = $validator->validateCPF($_POST['new_user_cpf']);
          if ($valid == 'válido') {
            $valid = $validator->celTest($_POST['new_user_cel']);
            if ($valid == 'válido') {
              $db = new UserModel;
              $check = $db->checkAlreadyUser($_POST['new_user_email'], $_POST['new_user_cpf']);
              if ($check != 'válido') {
                $error_new_user = $check;
              } else {
                $db->registerUser($_POST['new_user_name'], $_POST['new_user_email'], $_POST['new_user_cel'], $_POST['new_user_cpf'], $_POST['new_user_password']);
                $error_new_user = $db->confirmationEmail($_POST['new_user_email']);
              }
            } else {
              $error_new_user = $valid;
            }
          } else {
            $error_new_user = $valid;
          }
        } else {
          $error_new_user = $valid;
        }
      }
    }
    include('view/loginNew.php');
  }
  public function confirmation()
  {
    unset($error_confirmation_token);
    if (isset($_GET['id']) && strlen($_GET['id']) > 0 && isset($_GET['token']) && strlen($_GET['token']) > 0) {
      $validator = new Validator;
      $valid = $validator->confirmToken($_GET['id'], $_GET['token']);
      if ($valid = 'válido') {
        $db = new UserModel;
        $error_confirmation_token = $db->confirmUser((int) $_GET['id'], $_GET['token']);
      } else {
        $error_confirmation_token = $valid;
      }
    }
    include('view/confirmation.php');
  }
  public function client()
  {
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    include('view/client.php');
  }
  public function editClient()
  {
    unset($error_edit_client);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_edit_client = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "email":
            if (isset($_POST['edit_email']) && strlen($_POST['edit_email']) > 0) {
              $validator = new Validator;
              $valid = $validator->typeUpdate($_POST['edit_email'], $_SESSION['user_id']);
              if ($valid == 'válido') {
                $db = new UserModel;
                $error_edit_client = $db->editEmail($_POST['edit_email'], $_SESSION['user_id']);
                if ($error_edit_client = 'Email atualizado com sucesso') {
                  $error_edit_client = $db->confirmationEmail($_POST['edit_email']);
                }
              } else {
                $error_edit_client = $valid;
              }
            } else {
              $error_edit_client = 'Email não preenchido';
            }
            break;
          case "info":
            if (isset($_POST['edit_cel']) && isset($_POST['edit_cpf']) && isset($_POST['edit_name'])) {
              $validator = new Validator;
              $valid = $validator->typeTest($_POST['edit_cel']);
              if ($valid == 'válido') {
                $valid = $validator->typeTest($_POST['edit_cpf']);
                if ($valid == 'válido') {
                  $valid = $validator->typeTest($_POST['edit_name']);
                  if ($valid == 'válido') {
                    $db = new UserModel;
                    $error_edit_client = $db->editInfo($_POST['edit_name'], $_POST['edit_cel'], $_POST['edit_cpf'], $_SESSION['user_id']);
                  } else {
                    $error_edit_client = $valid;
                  }
                } else {
                  $error_edit_client = $valid;
                }
              } else {
                $error_edit_client = $valid;
              }
            } else {
              $error_edit_client = 'Campo não preenchido';
            }
            break;
          case "new_pic":
            if (isset($_FILES['avatar'])) {
              $validator = new Validator;
              $valid = $validator->avatar($_FILES['avatar']);
              if ($valid == 'válido') {
                $db = new UserModel;
                $error_edit_client = $db->newAvatar($_FILES['avatar']['name'], $_FILES['avatar']['tmp_name'], $_SESSION['user_id']);
              } else {
                $error_edit_client = $valid;
              }
            }
            break;
          case "old_pic":
            $db = new UserModel;
            $error_edit_client = $db->oldAvatar($_SESSION['user_id']);
            break;
          default:
            $error_edit_client = 'Erro na operação';
        }
      }
    }
    include('view/editClient.php');
  }
  public function lostPassword()
  {
    unset($error_confirmation_token);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_confirmation_token = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case 'lost-password':
            if(isset($_POST['email']) && isset($_POST['cpf'])) {
              $valid = $validator->emailTest($_POST['email']);
              if ($valid == 'válido') {
                $valid = $validator->validateCPF($_POST['cpf']);
                if ($valid == 'válido') {
                  $db = new UserModel;
                  $error_confirmation_token = $db->lostPassword($_POST['email'], $_POST['cpf']);
                } else {
                  $error_confirmation_token = $valid;
                }
              } else {
                $error_confirmation_token = $valid;
              }
            }
            break;
          case 'new-password':
            if(isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['user'])) {
              $valid = $validator->newPassword($_POST['password'], $_POST['confirm_password'], $_POST['user']);
              if ($valid == 'válido') {
                $db = new UserModel;
                $error_confirmation_token = $db->newPassword($_POST['password'], (int) $_POST['user']);
              } else {
                $error_confirmation_token = $valid;
              }
            }
            break;
          default:
            $error_confirmation_token = 'Erro na operação';
        }
      }
    }
    include('view/lostPassword.php');
  }
}
