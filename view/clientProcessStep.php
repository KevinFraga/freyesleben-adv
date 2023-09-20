<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

$process = (int) htmlspecialchars($_GET['processo']);

$query = mysqli_prepare($connect, "SELECT m.protocol_number, i.step, b.type, DATE_FORMAT(m.updated_at, '%d/%m/%Y') FROM Mandy m INNER JOIN Irwin i ON m.step_id = i.id INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ? AND m.user_id = ?;");
mysqli_stmt_bind_param($query, 'ii', $process, $_SESSION['user_id']);
mysqli_stmt_execute($query);

mysqli_stmt_bind_result($query, $protocol, $step, $process_type, $atualizado);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
?>

<?php
if (isset($process_type)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <div class="title-display">
      <p class="title"><?= $process_type ?></p>
    </div>
    
    <div class="title-display">
      <p class="title">Status: <?= $step ?> em <?= $atualizado ?></p>
    </div>
    
    <div class="title-display">
      <p class="title">Número do Processo: <?= $protocol ?></p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/cliente/processos?id={$_SESSION['user_id']}" ?>">
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
        <a href="<?= "/cliente/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}

mysqli_close($connect);
?>

<?php include('view/footer.php'); ?>
