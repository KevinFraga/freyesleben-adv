<?php
require_once('middleware/session.php');
require_once('model/ProcessModel.php');
require_once('middleware/Validator.php');

class ProcessController
{
  public function processStart()
  {
    unset($error_new_process);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['process']) || strlen($_POST['process']) == 0) {
        $error_new_process = 'Processo inválido';
      } else {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['process']);
        if ($valid == 'válido') {
          $db = new ProcessModel;
          $error_new_process = $db->newProcess($_SESSION['user_id'], (int) $_POST['process']);
        } else {
          $error_new_process = $valid;
        }
      }
    }
    include('view/processStart.php');
  }
  public function processes()
  {
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    include('view/processes.php');
  }
  public function processSend()
  {
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    include('view/processSend.php');
  }
  public function processDocuments()
  {
    unset($error_file_upload);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_file_upload = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case 'upload':
            if (isset($_FILES['file']) && isset($_POST['user_id']) && isset($_POST['process_id']) && isset($_POST['file_type_id'])) {
              $valid = $validator->fileUpload($_FILES['file'], $_POST['user_id'], $_POST['process_id'], $_POST['file_type_id']);
              if ($valid == 'válido') {
                $db = new ProcessModel;
                $error_file_upload = $db->fileUpload($_FILES['file']['tmp_name'], $_FILES['file']['type'], (int) $_POST['user_id'], (int) $_POST['process_id'], (int) $_POST['file_type_id']);
              } else {
                $error_file_upload = $valid;
              }
            }
            break;
          case 'delete':
            if (isset($_POST['user_id']) && isset($_POST['process_id']) && isset($_POST['file_type_id'])) {
              $valid = $validator->fileDelete($_POST['user_id'], $_POST['process_id'], $_POST['file_type_id']);
              if ($valid == 'válido') {
                $db = new ProcessModel;
                $error_file_upload = $db->fileDelete((int) $_POST['user_id'], (int) $_POST['process_id'], (int) $_POST['file_type_id']);
              } else {
                $error_file_upload = $valid;
              }
            }
            break;
          default:
            $error_file_upload = 'Erro na operação';
        }
      }
    }
    include('view/processDocuments.php');
  }
  public function processContracts()
  {
    unset($error_file_upload);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_file_upload = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case 'upload':
            if (isset($_FILES['file']) && isset($_POST['user_id']) && isset($_POST['process_id']) && isset($_POST['file_type_id'])) {
              $valid = $validator->fileUpload($_FILES['file'], $_POST['user_id'], $_POST['process_id'], $_POST['file_type_id']);
              if ($valid == 'válido') {
                $db = new ProcessModel;
                $error_file_upload = $db->fileUpload($_FILES['file']['tmp_name'], $_FILES['file']['type'], (int) $_POST['user_id'], (int) $_POST['process_id'], (int) $_POST['file_type_id']);
              } else {
                $error_file_upload = $valid;
              }
            }
            break;
          case 'delete':
            if (isset($_POST['user_id']) && isset($_POST['process_id']) && isset($_POST['file_type_id'])) {
              $valid = $validator->fileDelete($_POST['user_id'], $_POST['process_id'], $_POST['file_type_id']);
              if ($valid == 'válido') {
                $db = new ProcessModel;
                $error_file_upload = $db->fileDelete((int) $_POST['user_id'], (int) $_POST['process_id'], (int) $_POST['file_type_id']);
              } else {
                $error_file_upload = $valid;
              }
            }
            break;
          case 'download':
            if (isset($_POST['file_type_id'])) {
              $valid = $validator->idTest($_POST['file_type_id']);
              if ($valid == 'válido') {
                $db = new ProcessModel;
                $contract = $db->downloadContract((int) $_POST['file_type_id']);
                if (file_exists($contract['path'])) {
                  $ext = pathinfo($contract['path'], PATHINFO_EXTENSION);
                  header("Content-Type: {$contract['ext']}; charset=utf-8");
                  header("Content-Length: {$contract['size']}");
                  header("Content-Disposition: attachment; filename={$contract['type']}.$ext");
                  header("Cache-Control: no-cache, no-store, must-revalidate");
                  header("Pragma: no-cache");
                  header("Expires: 0");
                  readfile($contract['path']);
                } else {
                  $error_file_upload = 'Arquivo não encontrado';
                }
              } else {
                $error_file_upload = $valid;
              }
            }
            break;
          default:
            $error_file_upload = 'Erro na operação';
        }
      }
    }
    include('view/processContracts.php');
  }
  public function processFinish()
  {
    unset($error_finish);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['process']) || strlen($_POST['process']) == 0) {
        $error_finish = 'Processo inválido';
      } else {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['process']);
        if ($valid == 'válido') {
          $db = new ProcessModel;
          $error_finish = $db->processFinishedEmail($_SESSION['user_id'], (int) $_POST['process']);
        } else {
          $error_finish = $valid;
        }
      }
    }
    include('view/processFinish.php');
  }
  public function clientProcessStep()
  {
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    include('view/clientProcessStep.php');
  }
}
