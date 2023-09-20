<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div class="title-display">  
    <p class="title">Contador</p>
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
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
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
      <div class="file-input">
        <label class="label file-label" for="email_file" style="background-color: white; font-size: 1.2rem; margin-top: 1rem; width: 95%;">Anexo</label>
        <input type="file" name="email_file" id="email_file" />
        <span class="file-name" id="name_email_file" style="color: black;"></span>
      </div>
      <script>
        function updateName() {
          const input = document.getElementById("email_file");
          const target = document.getElementById("name_email_file");
          target.innerHTML = input.files[0].name;
        }
        
        document.getElementById("email_file").addEventListener('change', updateName);
      </script>
      <button type="submit" class="button">
        Enviar
      </button>
    </form>
  </div>
</main>

<?php include('view/footer.php'); ?>
