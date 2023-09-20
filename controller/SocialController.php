<?php
require_once('middleware/session.php');
require_once('model/SocialModel.php');
require_once('middleware/Validator.php');

class SocialController
{
  public function contact()
  {
    unset($error_email);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['email_name']) || strlen($_POST['email_name']) == 0) {
        $error_email = 'Nome não preenchido';
      } else if (!isset($_POST['email_email']) || strlen($_POST['email_email']) == 0) {
        $error_email = 'Email não preenchido';
      } else if (!isset($_POST['email_subject']) || strlen($_POST['email_subject']) == 0) {
        $error_email = 'Assunto não preenchido';
      } else if (!isset($_POST['email_text']) || strlen($_POST['email_text']) == 0) {
        $error_email = 'Texto não preenchido';
      } else {
        $validator = new Validator;
        $valid = $validator->email($_POST['email_name'], $_POST['email_email'], $_POST['email_subject'], $_POST['email_text']);
        if ($valid == 'válido') {
          $db = new SocialModel;
          $error_email = $db->contactUs($_POST['email_name'], $_POST['email_email'], $_POST['email_subject'], $_POST['email_text']);
        } else {
          $error_email = $valid;
        }
      }
    }
    include('view/contact.php');
  }
  public function receipts()
  {
    unset($error_email);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'ctd') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['email_name']) || strlen($_POST['email_name']) == 0) {
        $error_email = 'Nome não preenchido';
      } else if (!isset($_POST['email_email']) || strlen($_POST['email_email']) == 0) {
        $error_email = 'Email não preenchido';
      } else if (!isset($_POST['email_subject']) || strlen($_POST['email_subject']) == 0) {
        $error_email = 'Assunto não preenchido';
      } else if (!isset($_POST['email_text']) || strlen($_POST['email_text']) == 0) {
        $error_email = 'Texto não preenchido';
      }else if (!isset($_FILES['email_file'])) {
        $error_email = 'Anexo não enviado';
      } else {
        $validator = new Validator;
        $valid = $validator->email($_POST['email_name'], $_POST['email_email'], $_POST['email_subject'], $_POST['email_text']);
        if ($valid == 'válido') {
          $valid = $validator->contractFile($_FILES['email_file']);
          if ($valid == 'válido') {
            $db = new SocialModel;
            $error_email = $db->receipt($_POST['email_name'], $_POST['email_email'], $_POST['email_subject'], $_POST['email_text'], $_FILES['email_file']);
          } else {
            $error_email = $valid;
          }
        } else {
          $error_email = $valid;
        }
      }
    }
    include('view/receipts.php');
  }
  public function partners()
  {
    unset($error_partners);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['partner']) && strlen($_POST['partner']) > 0) {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['partner']);
        if ($valid == 'válido') {
          $db = new SocialModel;
          $db->deletePartner((int) $_POST['partner']);
        } else {
          $error_partners = $valid;
        }
      }
    }
    include('view/partners.php');
  }
  public function partnerNew()
  {
    unset($error_new_partner);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adv') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['partner_name']) || strlen($_POST['partner_name']) == 0) {
        $error_new_partner = 'Marca não preenchida';
      } else if (!isset($_POST['partner_description']) || strlen($_POST['partner_description']) == 0) {
        $error_new_partner = 'Descrição não preenchida';
      } else {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['partner_name']);
        if ($valid == 'válido') {
          $valid = $validator->typeTest($_POST['partner_description']);
          if ($valid == 'válido') {
            $db = new SocialModel;
            $error_new_partner = $db->newPartner($_POST['partner_name'], $_POST['partner_description']);
          } else {
            $error_new_partner = $valid;
          }
        } else {
          $error_new_partner = $valid;
        }
      }
    }
    include('view/partnerNew.php');
  }
  public function partnerEdit()
  {
    unset($error_edit_partner);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adv') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['parceiro']) || strlen($_GET['parceiro']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_edit_partner = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "new-logo":
            if (isset($_FILES['partner_logo']) && $_POST['partner_id']) {
              $valid = $validator->idTest($_POST['partner_id']);
              if ($valid == 'válido') {
                $valid = $validator->avatar($_FILES['partner_logo']);
                if ($valid == 'válido') {
                  $db = new SocialModel;
                  $error_edit_partner = $db->partnerNewLogo((int) $_POST['partner_id'], $_FILES['partner_logo']['name'], $_FILES['partner_logo']['tmp_name']);
                } else {
                  $error_edit_partner = $valid;
                }
              } else {
                $error_edit_partner = $valid;
              }
            }
            break;
          case "old-logo":
            if (isset($_POST['partner_id'])) {
              $valid = $validator->idTest($_POST['partner_id']);
              if ($valid == 'válido') {
                $db = new SocialModel;
                $db->partnerOldLogo((int) $_POST['partner_id']);
              } else {
                $error_edit_partner = $valid;
              }
            }
            break;
          case "description":
            if (isset($_POST['partner_id']) && isset($_POST['partner_name']) && isset($_POST['partner_description'])) {
              $valid = $validator->typeTest($_POST['partner_name']);
              if ($valid == 'válido') {
                $valid = $validator->typeTest($_POST['partner_description']);
                if ($valid == 'válido') {
                  $valid = $validator->idTest($_POST['partner_id']);
                  if ($valid == 'válido') {
                    $db = new SocialModel;
                    $error_edit_partner = $db->partnerEdit((int) $_POST['partner_id'], $_POST['partner_name'], $_POST['partner_description']);
                  } else {
                    $error_edit_partner = $valid;
                  }
                } else {
                  $error_edit_partner = $valid;
                }
              } else {
                $error_edit_partner = $valid;
              }
            }
            break;
          default:
            $error_edit_partner = 'Erro na operação';
        }
      }
    }
    include('view/partnerEdit.php');
  }
  public function lives()
  {
    include('view/video.php');
  }
  public function livesManager()
  {
    unset($error_video);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adv') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_video = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "new":
            if (!isset($_POST['videoTitle']) || strlen($_POST['videoTitle']) == 0) {
              $error_video = 'Título não preenchido';
              break;
            }
            if (!isset($_POST['videoURL']) || strlen($_POST['videoURL']) == 0) {
              $error_video = 'URL não preenchida';
              break;
            }
            $valid = $validator->typeTest($_POST['videoTitle']);
            if ($valid == 'válido') {
              $valid = $validator->typeTest($_POST['videoURL']);
              if ($valid == 'válido') {
                $db = new SocialModel;
                $error_video = $db->newVideo($_POST['videoTitle'], $_POST['videoURL']);
              } else {
                $error_video = $valid;
              }
            } else {
              $error_video = $valid;
            }
            break;
          case "select":
            if (isset($_POST['video_id'])) {
              $valid = $validator->idTest($_POST['video_id']);
              if ($valid == 'válido') {
                $db = new SocialModel;
                $error_video = $db->selectVideo((int) $_POST['video_id']);
              } else {
                $error_video = $valid;
              }
            }
            break;
          default:
            $error_video = 'Erro na operação';
        }
      }
    }
    include('view/videoManager.php');
  }
  public function cases()
  {
    include('view/cases.php');
  }
  public function whoWeAre()
  {
    include('view/cv.php');
  }
  public function privacy()
  {
    include('view/privacy.php');
  }
}
