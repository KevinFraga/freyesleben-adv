<?php require_once('middleware/session.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>
  
  <?php
  if (isset($error_new_partner)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_partner?></p>
    </div>
    <?php
  }
  ?>

  <div class="form">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
      <div>
        <label for="partner_name" class="label">Marca</label>
        <input type="text" name="partner_name" id="partner_name" />
      </div>
      <div>
        <label for="partner_description" class="label">Descrição</label>
        <textarea name="partner_description" id="partner_description"></textarea>
      </div>
      <button type="submit" class="button small">
        Adicionar
      </button>
    </form>
  </div>

  <div class="func-row">
    <div class="func-col">
      <a href="/parceiros">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Parceiros</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
