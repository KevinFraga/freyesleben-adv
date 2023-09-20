<?php require_once('middleware/session.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

$query = mysqli_prepare($connect, "SELECT COUNT(id) FROM Mandy WHERE user_id = ?;");
mysqli_stmt_bind_param($query, 'i', $_SESSION['user_id']);

mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $count);
mysqli_stmt_fetch($query);

mysqli_stmt_close($query);
mysqli_close($connect);
?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>

  <?php
  if ($_SESSION['user_kind'] != 'adm') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/cliente/processos/iniciar?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Iniciar Processo</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/cliente/info?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Editar Cadastro</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
  if ($count > 0) {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/cliente/processos/enviar?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Enviar Documentos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/cliente/processos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Consultar Processos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
  if ($_SESSION['user_kind'] == 'adv') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/documentos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Documentação</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/admin/contratos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Contratos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Processos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/admin/cliente?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Clientes</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
  if ($_SESSION['user_kind'] == 'ctd') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/contador?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Enviar Recibos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
  if ($_SESSION['user_kind'] == 'adm') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/super?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Atribuir Funções</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>
</main>

<?php include('view/footer.php'); ?>
