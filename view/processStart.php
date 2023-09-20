<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>
  
  <div class="title-display">
    <p class="p-text">Selecione o tipo de processo para o qual deseja nossa representação e em seguida clique no botão "Solicitar"</p>
  </div>
  
  <?php
   if (isset($error_new_process)) {
     ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_process?></p>
    </div>
    <?php
  }
  ?>
  
  <fieldset class="form">
    <legend>Solicitar Processo:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div class="input-holder">
        <label for="process" class="label">Processos</label>
        <select name="process" id="process">
          <option selected>Selecione o tipo de processo</option>
          <?php
          global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
          $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
          $connect->set_charset('utf8');

          $query = mysqli_query($connect, "SELECT id, type FROM Billy ORDER BY type;");

          while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <option value="<?= $row['id'] ?>">
              <?= $row['type'] ?>
            </option>
            <?php
          }

          mysqli_close($connect);
          ?>
        </select>
      </div>
      <button type="submit" class="button">
        Solicitar
      </button>
    </form>
  </fieldset>

  <div class="func-row">
    <div class="func-col">
      <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Voltar</span>
      </a>
    </div>
    <div class="func-col">
      <a href="<?= "/cliente/processos?id={$_SESSION['user_id']}" ?>">
        <span class="arrow">Consultar seus Processos</span>
        <span class="pointer">&rsaquo;</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
