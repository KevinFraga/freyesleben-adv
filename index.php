<?php
require_once('middleware/session.php');
require('controller/UserController.php');
require('controller/SocialController.php');
require('controller/PostController.php');
require('controller/ProcessController.php');
require('controller/AdminController.php');

$url = $_SERVER['SCRIPT_URL'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($url) {
  case "/":
    $controllerName = 'UserController';
    $view = 'home';
    break;
  case "/login":
    $controllerName = 'UserController';
    $view = 'login';
    break;
  case "/login/cadastrado":
    $controllerName = 'UserController';
    $view = 'loginOld';
    break;
  case "/login/novo":
    $controllerName = 'UserController';
    $view = 'loginNew';
    break;
  case "/causas":
    $controllerName = 'SocialController';
    $view = 'cases';
    break;
  case "/quem_somos":
    $controllerName = 'SocialController';
    $view = 'whoWeAre';
    break;
  case "/parceiros":
    $controllerName = 'SocialController';
    $view = 'partners';
    break;
  case "/parceiros/novo":
    $controllerName = 'SocialController';
    $view = 'partnerNew';
    break;
  case "/parceiros/editar":
    $controllerName = 'SocialController';
    $view = 'partnerEdit';
    break;
  case "/depoimentos":
    $controllerName = 'PostController';
    $view = 'feedback';
    break;
  case "/depoimentos/novo":
    $controllerName = 'PostController';
    $view = 'feedbackNew';
    break;
  case "/depoimentos/editar":
    $controllerName = 'PostController';
    $view = 'feedbackEdit';
    break;
  case "/blog":
    $controllerName = 'PostController';
    $view = 'blog';
    break;
  case "/blog/novo":
    $controllerName = 'PostController';
    $view = 'blogNewPost';
    break;
  case "/blog/editar":
    $controllerName = 'PostController';
    $view = 'blogEditPost';
    break;
  case "/lives":
    $controllerName = 'SocialController';
    $view = 'lives';
    break;
  case "/lives/admin":
    $controllerName = 'SocialController';
    $view = 'livesManager';
    break;
  case "/contato":
    $controllerName = 'SocialController';
    $view = 'contact';
    break;
  case "/contador":
    $controllerName = 'SocialController';
    $view = 'receipts';
    break;
  case "/privacidade":
    $controllerName = 'SocialController';
    $view = 'privacy';
    break;
  case "/confirmacao":
    $controllerName = 'UserController';
    $view = 'confirmation';
    break;
  case "/senha":
    $controllerName = 'UserController';
    $view = 'lostPassword';
    break;
  case "/cliente":
    $controllerName = 'UserController';
    $view = 'client';
    break;
  case "/cliente/info":
    $controllerName = 'UserController';
    $view = 'editClient';
    break;
  case "/cliente/processos":
    $controllerName = 'ProcessController';
    $view = 'processes';
    break;
  case "/cliente/processos/iniciar":
    $controllerName = 'ProcessController';
    $view = 'processStart';
    break;
  case "/cliente/processos/enviar":
    $controllerName = 'ProcessController';
    $view = 'processSend';
    break;
  case "/cliente/processos/enviar/documentos":
    $controllerName = 'ProcessController';
    $view = 'processDocuments';
    break;
  case "/cliente/processos/enviar/contratos":
    $controllerName = 'ProcessController';
    $view = 'processContracts';
    break;
  case "/cliente/processos/concluir":
    $controllerName = 'ProcessController';
    $view = 'processFinish';
    break;
  case "/cliente/processos/estado":
    $controllerName = 'ProcessController';
    $view = 'clientProcessStep';
    break;
  case "/admin/documentos":
    $controllerName = 'AdminController';
    $view = 'documentManager';
    break;
  case "/admin/contratos":
    $controllerName = 'AdminController';
    $view = 'contractManager';
    break;
  case "/admin/documentos/editar":
    $controllerName = 'AdminController';
    $view = 'editFile';
    break;
  case "/admin/processos":
    $controllerName = 'AdminController';
    $view = 'processManager';
    break;
  case "/admin/processos/editar":
    $controllerName = 'AdminController';
    $view = 'editProcess';
    break;
  case "/admin/processos/documentos":
    $controllerName = 'AdminController';
    $view = 'necessaryFiles';
    break;
  case "/admin/cliente":
    $controllerName = 'AdminController';
    $view = 'allClients';
    break;
  case "/admin/cliente/processos":
    $controllerName = 'AdminController';
    $view = 'clientProcesses';
    break;
  case "/admin/cliente/processos/documentos":
    $controllerName = 'AdminController';
    $view = 'clientFiles';
    break;
  case "/admin/cliente/processos/atualizar":
    $controllerName = 'AdminController';
    $view = 'processStep';
    break;
  case "/admin/cliente/processos/atualizar/editar":
    $controllerName = 'AdminController';
    $view = 'editStep';
    break;
  case "/admin/super":
    $controllerName = 'AdminController';
    $view = 'superAdmin';
    break;
  default:
    $controllerName = 'UserController';
    $view = 'home';
}

$controller = new $controllerName;
$controller->$view();
