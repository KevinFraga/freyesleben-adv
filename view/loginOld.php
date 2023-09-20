<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div class="title-display center">
    <p class="title">Acesso Exclusivo</p>
    <p class="subtitle">Área de Clientes Cadastrados</p>
  </div>
  
  <?php
  if (isset($error_login)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_login?></p>
    </div>
    <?php
  }
  ?>
  
  <div class="form">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div class="input-holder" id="login-email" <?= (isset($_POST['kind']) && $_POST['kind'] == 'cpf') ? 'style="display: none"' : '' ?>>
        <label for="email" class="label">E-mail</label>
        <input id="email" name="email" type="email" value="<?= isset($_POST['email']) ? $_POST['email'] : "" ?>" />
      </div>
      <div class="input-holder" id="login-cpf" <?= (!isset($_POST['kind']) || (isset($_POST['kind']) && $_POST['kind'] == 'email') || (isset($_POST['kind']) && ($_POST['kind'] != 'email' && $_POST['kind'] != 'cpf'))) ? 'style="display: none"' : '' ?>>
        <label for="cpf" class="label">CPF</label>
        <input id="cpf" name="cpf" type="text" oninput="handleCPF(this)" value="<?= isset($_POST['cpf']) ? $_POST['cpf'] : "" ?>" />
      </div>
      <div class="input-holder">
        <label for="password" class="label">Senha</label>
        <input id="password" name="password" type="password" value="<?= isset($_POST['password']) ? $_POST['password'] : "" ?>" />
        <img class="eye-toggler" id="eye-1" src="/view/images/eye-icon.png" alt="eye-toggler" />
      </div>
      <div class="radio-holder">
        <input id="radio_email" name="kind" type="radio" value="email" <?= (!isset($_POST['kind']) || (isset($_POST['kind']) && $_POST['kind'] == 'email') || (isset($_POST['kind']) && ($_POST['kind'] != 'email' && $_POST['kind'] != 'cpf'))) ? 'checked' : '' ?> />
        <label for="radio_email" style="margin-right: 3rem">E-mail</label>
        <input id="radio_cpf" name="kind" type="radio" value="cpf" <?= (isset($_POST['kind']) && $_POST['kind'] == 'cpf') ? 'checked' : '' ?> />
        <label for="radio_cpf">CPF</label>
      </div>
      <div class="login-button-container">
        <button type="submit" class="button">
          Entrar
        </button>
        <a href="/senha">
          <p class="step-text">Esqueci a senha</p>
        </a>
      </div>
    </form>
    <script src="/view/scripts/login-kind.js"></script>
    <script src="/view/scripts/password-eye.js"></script>
    <script src="/view/scripts/number-pattern.js"></script>
  </div>
</main>

<?php include('view/footer.php'); ?>
