<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
if (isset($_GET['id']) && strlen($_GET['id']) > 0 && isset($_GET['token']) && strlen($_GET['token']) > 0) {
  global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
  $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
  $connect->set_charset('utf8');

  $user_id = (int) htmlspecialchars($_GET['id']);

  $query = mysqli_prepare($connect, "SELECT name, confirmation_token FROM Chowder WHERE id = ?;");
  mysqli_stmt_bind_param($query, 'i', $user_id);

  mysqli_stmt_execute($query);
  mysqli_stmt_bind_result($query, $name, $token);

  if (!mysqli_stmt_fetch($query) || $token != htmlspecialchars($_GET['token'])) {
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
        <p class="p-text">Cadastre sua nova senha</p>
      </div>
      
      <?php
      if (isset($error_confirmation_token)) {
        ?> 
        <div class="title-display">
          <p class="form-error"><?= $error_confirmation_token?></p>
        </div>
        <?php
      }
      ?>

      <div class="form">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
          <div>
            <label for="password" class="label">Senha</label>
            <input id="password" name="password" type="password" />
            <img class="eye-toggler" id="eye-1" src="/view/images/eye-icon.png" alt="eye-toggler" />
          </div>
          <div>
            <label for="confirm_password" class="label">Confirmação da Senha</label>
            <input id="confirm_password" name="confirm_password" type="password" />
            <img class="eye-toggler" id="eye-2" src="/view/images/eye-icon.png" alt="eye-toggler" />
          </div>
          <input type="hidden" name="user" value="<?= $user_id ?>" />
          <input type="hidden" name="type" value="new-password" />
          <button type="submit" class="button">
            Cadastrar
          </button>
        </form>
        <script src="/view/scripts/lost-password-eye.js"></script>
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

  mysqli_stmt_close($query);
  mysqli_close($connect);

} else {
  ?>
  <main class="page-container">
    <div class="title-display">
      <p class="p-text">Confirme seu e-mail e cpf para continuar</p>
    </div>
    
    <?php
    if (isset($error_confirmation_token)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_confirmation_token?></p>
      </div>
      <?php
    }
    ?>

    <div class="form">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label for="email" class="label">E-mail</label>
          <input id="email" name="email" type="email" value="<?= isset($_POST['email']) ? $_POST['email'] : "" ?>" />
        </div>
        <div>
          <label for="cpf" class="label">CPF</label>
          <input id="cpf" name="cpf" type="text" pattern="\d{3}.\d{3}.\d{3}-\d{2}" oninput="handleCPF(this)" value="<?= isset($_POST['cpf']) ? $_POST['cpf'] : "" ?>" />
        </div>
        <input type="hidden" name="type" value="lost-password" />
        <button type="submit" class="button">
          Confirmar
        </button>
      </form>
      <script src="/view/scripts/number-pattern.js"></script>
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
