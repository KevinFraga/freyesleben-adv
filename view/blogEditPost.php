<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
$connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
$connect->set_charset('utf8');

$post = (int) htmlspecialchars($_GET['post']);
$query = mysqli_prepare($connect, "SELECT user_id, title, text FROM DeeDee WHERE id = ?;");

mysqli_stmt_bind_param($query, 'i', $post);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $author, $title, $text);

mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
mysqli_close($connect);

if (isset($author) && ($author == $_SESSION['user_id'] || $_SESSION['user_kind'] == 'adv')) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <?php
    if (isset($error_edit_blog)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_edit_blog?></p>
      </div>
      <?php
    }
    ?>

    <div class="form">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label for="blog-title" class="label">Título</label>
          <input id="blog-title" name="title" type="text" value="<?= $title ?>" />
        </div>
        <div>
          <label for="blog-text" class="label">Texto</label>
          <textarea id="blog-text" name="text"><?= $text ?></textarea>
        </div>
        <input type="hidden" name="post_id" value="<?= $post ?>" />
        <button type="submit" class="button">
          Atualizar
        </button>
      </form>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="/blog">
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
      <p class="form-error">Post não encontrado</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="/blog">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}
?>

<?php include('view/footer.php'); ?>
