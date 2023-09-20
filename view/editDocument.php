<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
$connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
$connect->set_charset('utf8');
$doc = (int) htmlspecialchars($_GET['documento']);

$query = mysqli_prepare($connect, "SELECT type, contract FROM Eustace WHERE id = ?;");
mysqli_stmt_bind_param($query, 'i', $doc);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $file_type, $is_contract);

mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
mysqli_close($connect);
?>

<?php
if (isset($file_type)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <?php
    if (isset($error_edit_document)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_edit_document?></p>
      </div>
      <?php
    }
    ?>
    
    <div class="form">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label class="label" for="fileType"><?= $is_contract ? "Nome do Contrato" : "Nome da Documentação" ?></label>
          <input type="text" id="fileType" name="fileType" value="<?= $file_type ?>" />
        </div>
        <input type="hidden" name="id" value="<?= $doc ?>" />
        <button type="submit" class="button">
          Atualizar
        </button>
      </form>  
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= $is_contract ? "/admin/contratos?id={$_SESSION['user_id']}" : "/admin/documentos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= $is_contract ? "/admin/documentos?id={$_SESSION['user_id']}" : "/admin/contratos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow"><?= $is_contract ? "Gerenciar Documentos" : "Gerenciar Contratos" ?></span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
  </main>
  <?php
} else {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <div class="title-display">
      <p class="form-error">Documentação não encontrada</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/documentos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Gerenciar Documentos</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/admin/contratos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Contratos</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}
?>

<?php include('view/footer.php'); ?>
