<?php require_once('middleware/session.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>
  
  <?php
  if (isset($error_new_feed)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_feed?></p>
    </div>
    <?php
  }
  ?>

  <div class="form">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="feed-title" class="label">Título</label>
        <input id="feed-title" name="title" type="text" />
      </div>
      <div>
        <label for="feed-text" class="label">Texto</label>
        <textarea id="feed-text" name="text"></textarea>
      </div>
      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
      <button type="submit" class="button">
        Postar
      </button>
    </form>
  </div>

  <div class="func-row">
    <div class="func-col">
      <a href="/depoimentos">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Depoimentos</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
