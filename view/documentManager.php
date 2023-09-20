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
    <p class="p-text">Nomeie o tipo de documento que os clientes deverão enviar ao iniciarem um processo e cadastre-o.</p>
    <p class="p-text">Para editar o nome do registro, clique na seta.</p>
  </div>

  <?php
  if (isset($error_new_file_type)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_file_type?></p>
    </div>
    <?php
  }
  ?>

  <fieldset class="form">
    <legend>Novo Documento:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="fileType" class="label">Nome da Documentação</label>
        <input id="fileType" name="fileType" type="text" />
      </div>
      <button type="submit" class="button">
        Cadastrar
      </button>
    </form>
  </fieldset>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Documentação</th>
          <th colspan="1" scope="col">Editar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
        $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
        $connect->set_charset('utf8');

        $query = mysqli_query($connect, "SELECT id, type FROM Eustace WHERE contract = FALSE ORDER BY type;");
  
        while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td><?= $row['type'] ?></td>
            <td>
              <a href="<?= "/admin/documentos/editar?id={$_SESSION['user_id']}&documento={$row['id']}" ?>" class="p-step">
                <span>&rsaquo;</span>
              </a>
            </td>
          </tr>
          <?php
        }
  
        mysqli_close($connect);
        ?>
      </tbody>
    </table>
  </div>

  <div class="func-row">
    <div class="func-col">
      <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Voltar</span>
      </a>
    </div>
    <div class="func-col">
      <a href="<?= "/admin/contratos?id={$_SESSION['user_id']}" ?>">
        <span class="arrow">Gerenciar Contratos</span>
        <span class="pointer">&rsaquo;</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
