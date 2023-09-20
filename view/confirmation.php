<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
if (isset($_GET['id']) && strlen($_GET['id']) > 0 && isset($_GET['token']) && strlen($_GET['token']) > 0) {
  global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
  $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
  $connect->set_charset('utf8');

  $query = mysqli_prepare($connect, "SELECT name, email_confirmed, confirmation_token FROM Chowder WHERE id = ?;");
  $user_id = (int) htmlspecialchars($_GET['id']);

  mysqli_stmt_bind_param($query, 'i', $user_id);
  mysqli_stmt_execute($query);
  mysqli_stmt_bind_result($query, $name, $confirmed, $token);

  if (!mysqli_stmt_fetch($query) || !$confirmed || $token != htmlspecialchars($_GET['token'])) {
    ?>
    <main class="page-container">
      <div class="title-display">
        <p class="p-text"><?= $error_confirmation_token ?></p>
      </div>

      <div class="func-row">
        <div class="func-col">
          <a href="/?logout">
            <span class="pointer">&lsaquo;</span>
            <span class="arrow">Início</span>
          </a>
        </div>
        <div class="func-col">
          <a href="/login?logout">
            <span class="arrow">Login</span>
            <span class="pointer">&rsaquo;</span>
          </a>
        </div>
      </div>
    </main>
    <?php
  } else {
    ?>
    <main class="page-container">
      <div class="title-display">
        <p class="p-text"><?= $error_confirmation_token ?>!</p>
      </div>
      
      <div class="title-display">
        <p class="p-text">Seja bem-vindo(a) <?= $name ?>.</p>
      </div>

      <div class="title-display">
        <p class="p-text">Faça login na sua conta para solicitar seus processos.</p>
      </div>

      <div class="func-row">
        <div class="func-col">
          <a href="/?logout">
            <span class="pointer">&lsaquo;</span>
            <span class="arrow">Início</span>
          </a>
        </div>
        <div class="func-col">
          <a href="/login">
            <span class="arrow">Login</span>
            <span class="pointer">&rsaquo;</span>
          </a>
        </div>
      </div>
    </main>
    <?php
  }

  mysqli_stmt_close($query);
  mysqli_close($connect);

} else {
  ?>
  <main class="page-container">
    <div class="title-display">
      <p class="p-text">Faça o login na sua conta para continuar</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="/?logout">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Início</span>
        </a>
      </div>
      <div class="func-col">
        <a href="/login?logout">
          <span class="arrow">Login</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}
?>

<?php include('view/footer.php'); ?>
