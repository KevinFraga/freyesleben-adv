<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div class="title-display center">
    <p class="title">Acesso Exclusivo</p>
    <p class="subtitle">Fale com o escritório para obter uma chave de acesso</p>
  </div>
  
  <?php
  if (isset($error_locked)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_locked?></p>
    </div>
    <?php
  }
  ?>
  
  <div class="form">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div class="input-holder">
        <label for="lock" class="label">Acesso</label>
        <input id="lock" name="lock" type="password" />
        <img class="eye-toggler" id="eye-4" src="/view/images/eye-icon.png" alt="eye-toggler" />
      </div>
      <div>
        <button type="submit" class="button">
          Criar Cadastro
        </button>
        <a href="/login/cadastrado" class="button">
          Tenho Cadastro
        </a>
      </div>
    </form>
    <script src="/view/scripts/password-eye.js"></script>
  </div>
</main>

<?php include('view/footer.php'); ?>
