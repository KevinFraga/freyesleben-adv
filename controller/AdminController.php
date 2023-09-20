<?php
require_once('middleware/session.php');
require_once('model/AdminModel.php');
require_once('middleware/Validator.php');

class AdminController
{
  public function documentManager()
  {
    unset($error_new_file_type);
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
      if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0) {
        $error_new_file_type = 'Erro na operação';
      } else {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['fileType']);
        if ($valid == 'válido') {
          $db = new AdminModel;
          $error_new_file_type = $db->newFileType($_POST['fileType'], FALSE);
        } else {
          $error_new_file_type = $valid;
        }
      }
    }
    include('view/documentManager.php');
  }
  public function contractManager()
  {
    unset($error_new_contract);
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
        $error_new_contract = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case 'insert':
            if (!isset($_POST['fileType']) || !isset($_FILES['contract'])) {
              $error_new_contract = 'Erro na operação';
            } else {
              $valid = $validator->contractFile($_FILES['contract']);
              if ($valid == 'válido') {
                $valid = $validator->typeTest($_POST['fileType']);
                if ($valid == 'válido') {
                  $db = new AdminModel;
                  $error_new_contract = $db->newContract($_FILES['contract']['name'], $_FILES['contract']['tmp_name'], $_FILES['contract']['type'], (int) $_POST['fileType']);
                } else {
                  $error_new_contract = $valid;
                }
              } else {
                $error_new_contract = $valid;
              }
            }
            break;
          case 'delete':
            if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0) {
              $error_new_contract = 'Erro na operação';
            } else {
              $valid = $validator->idTest($_POST['fileType']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $error_new_contract = $db->deleteContract((int) $_POST['fileType']);
              } else {
                $error_new_contract = $valid;
              }
            }
            break;
          case 'create':
            if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0) {
              $error_new_contract = 'Erro na operação';
            } else {
              $valid = $validator->typeTest($_POST['fileType']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $error_new_contract = $db->newFileType($_POST['fileType'], TRUE);
              } else {
                $error_new_contract = $valid;
              }
            }
            break;
          default:
            $error_new_contract = 'Erro na operação';
        }
      }
    }
    include('view/contractManager.php');
  }
  public function editFile()
  {
    unset($error_edit_document);
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
    if (!isset($_GET['documento']) || strlen($_GET['documento']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0 || !isset($_POST['id']) || strlen($_POST['id']) == 0) {
        $error_edit_document = 'Erro na operação';
      } else {
        $validator = new Validator;
        $valid = $validator->typeUpdate($_POST['fileType'], $_POST['id']);
        if ($valid == 'válido') {
          $db = new AdminModel;
          $error_edit_document = $db->updateFileType($_POST['fileType'], (int) $_POST['id']);
        } else {
          $error_edit_document = $valid;
        }
      }
    }
    include('view/editDocument.php');
  }
  public function processManager()
  {
    unset($error_new_process_type);
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
      if (!isset($_POST['processType']) || strlen($_POST['processType']) == 0) {
        $error_new_process_type = 'Processo inválido';
      } else {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['processType']);
        if ($valid == 'válido') {
          $db = new AdminModel;
          $error_new_process_type = $db->newProcessType($_POST['processType']);
        } else {
          $error_new_process_type = $valid;
        }
      }
    }
    include('view/processManager.php');
  }
  public function editProcess()
  {
    unset($error_edit_process);
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
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['processType']) || strlen($_POST['processType']) == 0 || !isset($_POST['id']) || strlen($_POST['id']) == 0) {
        $error_edit_process = 'Erro na operação';
      } else {
        $validator = new Validator;
        $valid = $validator->typeUpdate($_POST['processType'], $_POST['id']);
        if ($valid == 'válido') {
          $db = new AdminModel;
          $error_edit_process = $db->updateProcessType($_POST['processType'], (int) $_POST['id']);
        } else {
          $error_edit_process = $valid;
        }
      }
    }
    include('view/editProcess.php');
  }
  public function necessaryFiles()
  {
    unset($error_new_necessary_file);
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
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_new_necessary_file = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "insert":
            if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0) {
              $error_new_necessary_file = 'Erro na operação';
            } else {
              $valid = $validator->newNecessaryFile($_GET['processo'], $_POST['fileType']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $already = $db->checkAlreadyNecessaryFile((int) $_GET['processo'], (int) $_POST['fileType']);
                if ($already == 'válido') {
                  $error_new_necessary_file = $db->newNecessaryFile((int) $_GET['processo'], (int) $_POST['fileType']);
                } else {
                  $error_new_necessary_file = $already;
                }
              } else {
                $error_new_necessary_file = $valid;
              }
            }
            break;
          case "delete":
            if (!isset($_POST['fileType']) || strlen($_POST['fileType']) == 0) {
              $error_new_necessary_file = 'Erro na operação';
            } else {
              $valid = $validator->newNecessaryFile($_GET['processo'], $_POST['fileType']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $db->deleteNecessaryFile((int) $_GET['processo'], (int) $_POST['fileType']);
              } else {
                $error_new_necessary_file = $valid;
              }
            }
            break;
          default:
            $error_new_necessary_file = 'Erro na operação';
        }
      }
    }
    include('view/necessaryFiles.php');
  }
  public function allClients()
  {
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
    include('view/allClients.php');
  }
  public function clientProcesses()
  {
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
    if (!isset($_GET['cliente']) || strlen($_GET['cliente']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    include('view/clientProcesses.php');
  }
  public function clientFiles()
  {
    unset($error_download);
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
    if (!isset($_GET['cliente']) || strlen($_GET['cliente']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['user_id']) || strlen($_POST['user_id']) == 0 || !isset($_POST['process_id']) || strlen($_POST['process_id']) == 0 || !isset($_POST['file_type_id']) || strlen($_POST['file_type_id']) == 0) {
        $error_download = 'Erro na operação';
      } else {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['user_id']);
        if ($valid == 'válido') {
          $valid = $validator->idTest($_POST['process_id']);
          if ($valid == 'válido') {
            $valid = $validator->idTest($_POST['file_type_id']);
            if ($valid == 'válido') {
              $db = new AdminModel;
              $file = $db->downloadClientFile((int) $_POST['user_id'], (int) $_POST['process_id'], (int) $_POST['file_type_id']);
              header("Content-Type: {$file['ext']}; charset=utf-8");
              header("Content-Length: {$file['size']}");
              header("Content-Disposition: attachment; filename={$file['name']}");
              header("Cache-Control: no-cache, no-store, must-revalidate");
              header("Pragma: no-cache");
              header("Expires: 0");
              readfile($file['path']);
              unlink($file['path']);
            } else {
              $error_download = $valid;
            }
          } else {
            $error_download = $valid;
          }
        } else {
          $error_download = $valid;
        }
      }
    }
    include('view/clientFiles.php');
  }
  public function processStep()
  {
    unset($error_step);
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
    if (!isset($_GET['cliente']) || strlen($_GET['cliente']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_step = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "protocol":
            if (isset($_POST['user']) && isset($_POST['process']) && isset($_POST['protocol'])) {
              $valid = $validator->idTest($_POST['user']);
              if ($valid == 'válido') {
                $valid = $validator->idTest($_POST['process']);
                if ($valid == 'válido') {
                  $valid = $validator->typeTest($_POST['protocol']);
                  if ($valid == 'válido') {
                    $db = new AdminModel;
                    $error_step = $db->protocolNumber((int) $_POST['user'], (int) $_POST['process'], $_POST['protocol']);
                  } else {
                    $error_step = $valid;
                  }
                } else {
                  $error_step = $valid;
                }
              } else {
                $error_step = $valid;
              }
            }
            break;
          case "step":
            if (isset($_POST['user']) && isset($_POST['process']) && isset($_POST['step'])) {
              $valid = $validator->idTest($_POST['user']);
              if ($valid == 'válido') {
                $valid = $validator->idTest($_POST['process']);
                if ($valid == 'válido') {
                  $valid = $validator->idTest($_POST['step']);
                  if ($valid == 'válido') {
                    $db = new AdminModel;
                    $error_step = $db->processStep((int) $_POST['user'], (int) $_POST['process'], (int) $_POST['step']);
                  } else {
                    $error_step = $valid;
                  }
                } else {
                  $error_step = $valid;
                }
              } else {
                $error_step = $valid;
              }
            }
            break;
          case "new_step":
            if (isset($_POST['new_step'])) {
              $valid = $validator->typeTest($_POST['new_step']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $error_step = $db->newStep($_POST['new_step']);
              } else {
                $error_step = $valid;
              }
            }
            break;
          default:
            $error_step = 'Erro na operação';
        }
      }
    }
    include('view/processStep.php');
  }
  public function editStep()
  {
    unset($error_edit_step);
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
    if (!isset($_GET['cliente']) || strlen($_GET['cliente']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['processo']) || strlen($_GET['processo']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['step']) || strlen($_POST['step']) == 0 || !isset($_POST['id']) || strlen($_POST['id']) == 0) {
        $error_edit_step = 'Erro na operação';
      } else {
        $validator = new Validator;
        $valid = $validator->typeUpdate($_POST['step'], $_POST['id']);
        if ($valid == 'válido') {
          $db = new AdminModel;
          $error_edit_step = $db->updateStep($_POST['step'], (int) $_POST['id']);
        } else {
          $error_edit_step = $valid;
        }
      }
    }
    include('view/editStep.php');
  }
  public function superAdmin()
  {
    unset($error_super);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adm') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!isset($_POST['type'])) {
        $error_super = 'Erro na operação';
      } else {
        $validator = new Validator;
        switch ($_POST['type']) {
          case "in":
            if (isset($_POST['user']) && isset($_POST['kind'])) {
              $valid = $validator->idTest($_POST['user']);
              if ($valid == 'válido') {
                $valid = $validator->typeTest($_POST['kind']);
                if ($valid == 'válido') {
                  $db = new AdminModel;
                  $error_super = $db->giveKind((int) $_POST['user'], $_POST['kind']);
                } else {
                  $error_super = $valid;
                }
              } else {
                $error_super = $valid;
              }
            }
            break;
          case "out":
            if (isset($_POST['user'])) {
              $valid = $validator->idTest($_POST['user']);
              if ($valid == 'válido') {
                $db = new AdminModel;
                $error_super = $db->removeKind((int) $_POST['user']);
              } else {
                $error_super = $valid;
              }
            }
            break;
          default:
            $error_super = 'Erro na operação';
        }
      }
    }
    include('view/superAdmin.php');
  }
}
