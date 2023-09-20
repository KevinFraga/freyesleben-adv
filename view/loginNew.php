<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div class="title-display center">
    <p class="title">Ainda Não Faz Parte da Comunidade?</p>
    <p class="subtitle">Cadastre-se aqui, todos os campos são obrigatórios</p>
  </div>
  
  <?php
    if (isset($error_new_user)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_user?></p>
    </div>
    <?php
  }
  ?>

  <div class="form alt">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div class="input-holder">
        <label for="new_user_name" class="label">Nome Completo</label>
        <input id="new_user_name" name="new_user_name" type="name" value="<?= isset($_POST['new_user_name']) ? $_POST['new_user_name'] : "" ?>" />
      </div>
      <div class="input-holder">
        <label for="new_user_email" class="label">E-mail</label>
        <input id="new_user_email" name="new_user_email" type="email" value="<?= isset($_POST['new_user_email']) ? $_POST['new_user_email'] : "" ?>" />
      </div>
      <div class="input-holder">
        <label for="new_user_email_confirm" class="label">Confirmação de E-mail</label>
        <input id="new_user_email_confirm" name="new_user_email_confirm" type="email" value="<?= isset($_POST['new_user_email_confirm']) ? $_POST['new_user_email_confirm'] : "" ?>" />
      </div>
      <div class="input-holder">
        <label for="new_user_cel" class="label">Celular</label>
        <input id="new_user_cel" name="new_user_cel" type="text" value="<?= isset($_POST['new_user_cel']) ? $_POST['new_user_cel'] : "" ?>" oninput="handlePhone(this)" />
      </div>
      <div class="input-holder">
        <label for="new_user_cpf" class="label">CPF</label>
        <input id="new_user_cpf" name="new_user_cpf" type="text" pattern="\d{3}.\d{3}.\d{3}-\d{2}" value="<?= isset($_POST['new_user_cpf']) ? $_POST['new_user_cpf'] : "" ?>" oninput="handleCPF(this)" />
      </div>
      <div class="input-holder">
        <label for="new_user_password" class="label">Senha (mínimo 8 caracteres)</label>
        <input id="new_user_password" name="new_user_password" type="password" value="<?= isset($_POST['new_user_password']) ? $_POST['new_user_password'] : "" ?>" />
        <img class="eye-toggler" id="eye-2" src="/view/images/eye-icon.png" alt="eye-toggler" />
      </div>
      <div class="input-holder">
        <label for="new_user_password_confirm" class="label">Confirmação de Senha</label>
        <input id="new_user_password_confirm" name="new_user_password_confirm" type="password" value="<?= isset($_POST['new_user_password_confirm']) ? $_POST['new_user_password_confirm'] : "" ?>" />
        <img class="eye-toggler" id="eye-3" src="/view/images/eye-icon.png" alt="eye-toggler" />
      </div>
      <div class="checkbox-holder">
        <input id="terms" name="terms" type="checkbox" <?= isset($_POST['terms']) ? 'checked' : '' ?> />
        <label for="terms">Aceito os termos e condições do escritório</label>
      </div>
      <button type="submit" class="button">
        Cadastrar
      </button>
    </form>
    <script src="/view/scripts/password-eye.js"></script>
    <script src="/view/scripts/number-pattern.js"></script>
  </div>
</main>

<?php include('view/footer.php'); ?>
