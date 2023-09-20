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
    <p class="p-text">Nomeie o tipo de processo que os clientes poderão solicitar e cadastre-o.</p>
    <p class="p-text">Defina qual a documentação necessária para a abertura de cada processo clicando no ícone de documentação correspondente.</p>
    <p class="p-text">Para editar o nome do registro, clique na seta.</p>
  </div>
  
  <?php
    if (isset($error_new_process_type)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_process_type?></p>
    </div>
    <?php
  }
  ?>
  
  <fieldset class="form">
    <legend>Novo Processo:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="processType" class="label">Nome do Processo</label>
        <input id="processType" name="processType" type="text" />
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
          <th colspan="1" scope="col">Processo</th>
          <th colspan="1" scope="col">Documentação Necessária</th>
          <th colspan="1" scope="col">Editar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
        $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
        $connect->set_charset('utf8');

        $query = mysqli_query($connect, "SELECT id, type FROM Billy ORDER BY type;");
  
        while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td class="t-file"><?= $row['type'] ?></td>
            <td class="t-title">
              <a href="<?= "/admin/processos/documentos?id={$_SESSION['user_id']}&processo={$row['id']}" ?>" class="p-step">
                <img class="big-icon" src="/view/images/blank-icon.png" alt="document-icon" />
              </a>
            </td>
            <td>
              <a href="<?= "/admin/processos/editar?id={$_SESSION['user_id']}&processo={$row['id']}" ?>" class="p-step">
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
      <a href="<?= "/admin/cliente?id={$_SESSION['user_id']}" ?>">
        <span class="arrow">Gerenciar Clientes</span>
        <span class="pointer">&rsaquo;</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
