<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
$connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
$connect->set_charset('utf8');

$partner = (int) htmlspecialchars($_GET['parceiro']);

$query = mysqli_prepare($connect, "SELECT partner, logo, description FROM Mandark WHERE id = ?;");
mysqli_stmt_bind_param($query, 'i', $partner);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $partner_name, $partner_logo, $partner_description);

mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
mysqli_close($connect);
?>

<?php
if (isset($partner_name)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>
    
    <div class="title-display">
      <p class="p-text">A logo deve ser um arquivo png com fundo transparente.</p>
    </div>
    
    <?php
     if (isset($error_edit_partner)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_edit_partner?></p>
      </div>
      <?php
    }
    ?>

    <fieldset class="form">
      <legend>Atualizar Logo:</legend>
      <div class="partner-logo-container">
        <div class="partner-logo">
          <img src="<?= "/$partner_logo" ?>" alt="<?= "$partner_name-logo" ?>" />
        </div>
      </div>

      <?php
      if ($partner_logo == "view/images/new-user.png") {
        ?>
        <div class="partner-edit">
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
            <div class="file-input">
              <label class="label file-label" for="partner_logo">Logo</label>
              <input type="file" name="partner_logo" id="partner_logo" />
              <span class="file-name" id="name_partner_logo"></span>
            </div>
            <input type="hidden" name="partner_id" value="<?= $partner ?>" />
            <input type="hidden" name="type" value="new-logo" />
            <button type="submit" class="button">
              Atualizar Logo
            </button>
          </form>
          <script src="/view/scripts/partner-logo-name.js"></script>
        </div>
        <?php
      } else {
        ?>
        <div>
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <input type="hidden" name="partner_id" value="<?= $partner ?>" />
            <input type="hidden" name="type" value="old-logo" />
            <button type="submit" class="button">
              Alterar Logo
            </button>
          </form>
        </div>
        <?php
      }
      ?>
    </fieldset>

    <fieldset class="form">
      <legend>Atualizar Informações:</legend>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label for="partner_name" class="label">Marca</label>
          <input type="text" name="partner_name" id="partner_name" value="<?= $partner_name ?>" />
        </div>
        <div>
          <label for="partner_description" class="label">Descrição</label>
          <textarea name="partner_description" id="partner_description"><?= $partner_description ?></textarea>
        </div>
        <input type="hidden" name="partner_id" value="<?= $partner ?>" />
        <input type="hidden" name="type" value="description" />
        <button type="submit" class="button">
          Atualizar Informações
        </button>
      </form>
    </fieldset>

    <div class="func-row">
      <div class="func-col">
        <a href="/parceiros">
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
      <p class="form-error">Parceiro não encontrado</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="/parceiros">
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
