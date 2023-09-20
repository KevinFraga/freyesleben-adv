<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
$connect = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
$connect->set_charset('utf8');

$query = mysqli_query($connect, "SELECT video FROM SpaceGhost WHERE selected = TRUE;");
$row = mysqli_fetch_assoc($query);
mysqli_close($connect);
?>

<main class="page-container">
  <div class="title-display">
    <p class="title">Nossas Lives</p>
  </div>
  <span class="subtitle">Fique por dentro</span>

  <div class="video-container">
    <iframe src="<?= "https://www.youtube.com/embed/{$row['video']}" ?>" class="video" frameborder="0"
      allow="autoplay; encrypted-media" allowfullscreen></iframe>
  </div>

  <?php
  if (isset($_SESSION['user_kind']) && $_SESSION['user_kind'] == 'adv') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="/">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Início</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/lives/admin?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Vídeo</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>
</main>

<?php include('view/footer.php'); ?>
