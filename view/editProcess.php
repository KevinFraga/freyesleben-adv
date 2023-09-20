<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

$process = (int) htmlspecialchars($_GET['processo']);

$query = mysqli_prepare($connect, "SELECT type FROM Billy WHERE id = ?;");
mysqli_stmt_bind_param($query, 'i', $process);
mysqli_stmt_execute($query);

mysqli_stmt_bind_result($query, $process_type);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
mysqli_close($connect);
?>

<?php
if (isset($process_type)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <?php
    if (isset($error_edit_process)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_edit_process?></p>
      </div>
      <?php
    }
    ?>

    <div class="form">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label class="label" for="processType">Nome do Processo</label>
          <input type="text" id="processType" name="processType" value="<?= $process_type ?>" />
        </div>
        <input type="hidden" name="id" value="<?= $process ?>" />
        <button type="submit" class="button">
          Atualizar
        </button>
      </form>  
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
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
      <p class="form-error">Processo não encontrado</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}
?>

<?php include('view/footer.php'); ?>
