<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>


<main class="page-container">
  <div class="title-display">  
    <p class="title">Fale Conosco</p>
  </div>

  <?php
  if (isset($error_email)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_email?></p>
    </div>
    <?php
  }
  ?>

  <div class="form alt">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="email_name" class="label">Nome</label>
        <input type="name" id="email_name" name="email_name" />
      </div>
      <div>
        <label for="email_email" class="label">E-mail</label>
        <input type="email" id="email_email" name="email_email" />
      </div>
      <div>
        <label for="email_subject" class="label">Assunto</label>
        <input type="email_text" id="email_subject" name="email_subject" />
      </div>
      <div>
        <label for="email_text" class="label">Texto</label>
        <textarea id="email_text" name="email_text"></textarea>
      </div>
      <button type="submit" class="button">
        Enviar
      </button>
    </form>
  </div>

  <div class="credits">
    <div class="c-text-holder">
      <p class="credit-text">Designed & Performed By</p>
      <p class="credit-subtext">Todos os direitos reservados</p>
      <p class="credit-subtext">2023 &copy; kayah design</p>
    </div>
    <div class="c-logo">
      <img class="big-icon" src="/view/images/Kayah Design-logo.png" alt="kayah design logo" />
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
