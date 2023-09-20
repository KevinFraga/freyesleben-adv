<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
$connect2 = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
$connect2->set_charset('utf8');

$user = (int) htmlspecialchars($_GET['cliente']);
$process = (int) htmlspecialchars($_GET['processo']);

$query2 = mysqli_prepare($connect, "SELECT b.type, m.protocol_number, i.step FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id INNER JOIN Irwin i ON m.step_id = i.id WHERE m.id = ? AND m.user_id = ?;");
mysqli_stmt_bind_param($query2, 'ii', $process, $user);
mysqli_stmt_execute($query2);

mysqli_stmt_bind_result($query2, $process_type, $protocol_number, $current_step);
mysqli_stmt_fetch($query2);
mysqli_stmt_close($query2);

$query3 = mysqli_prepare($connect2, "SELECT name FROM Chowder WHERE id = ?;");
mysqli_stmt_bind_param($query3, 'i', $user);
mysqli_stmt_execute($query3);

mysqli_stmt_bind_result($query3, $client);
mysqli_stmt_fetch($query3);
mysqli_stmt_close($query3);
?>

<?php
if (isset($process_type)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <div class="title-display">
      <p class="p-text">Atualize as informações do processo, como o número do protocolo e seu estado atual.</p>
      <p class="p-text">Selecione o Estado do Processo desejado na lista.</p>
      <p class="p-text">Cada vez que o Estado do Processo for atualizado, o cliente será informado por e-mail.</p>
      <p class="p-text">Para criar um novo Estado de Processo, utilize o último formulário.</p>
      <p class="p-text">Para editar um Estado de Processo salvo, clique em Editar na tabela no final da página.</p>
    </div>

    <div class="title-display">
      <p class="title"><?= $client ?></p>
    </div>
    
    <div class="title-display">
      <p class="title"><?= $process_type ?></p>
    </div>

    <div class="title-display">
      <p class="title">Estado Atual: <?= $current_step ?></p>
    </div>

    <?php
    if (isset($error_step)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_step?></p>
      </div>
      <?php
    }
    ?>

    <fieldset class="form">
      <legend>Número do Protocolo:</legend>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label class="label" for="protocol">Número do Processo</label>
          <input type="text" id="protocol" name="protocol" value="<?= $protocol_number ?>" />
        </div>
        <input type="hidden" name="user" value="<?= $user ?>" />
        <input type="hidden" name="process" value="<?= $process ?>" />
        <input type="hidden" name="type" value="protocol" />
        <button type="submit" class="button">
          Atualizar Número do Processo
        </button>
      </form>
    </fieldset>

    <fieldset class="form">
      <legend>Atualizar Estado:</legend>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label class="label" for="step">Estado do Processo</label>
          <select id="step" name="step">
            <?php
            $query = mysqli_query($connect, "SELECT id, step FROM Irwin ORDER BY id;");

            while ($row = mysqli_fetch_assoc($query)) {
              ?>
              <option value="<?= $row['id'] ?>"><?= $row['step'] ?></option>
              <?php
            }

            ?>
          </select>
        </div>
        <input type="hidden" name="user" value="<?= $user ?>" />
        <input type="hidden" name="process" value="<?= $process ?>" />
        <input type="hidden" name="type" value="step" />
        <button type="submit" class="button">
          Atualizar Processo
        </button>
      </form>
    </fieldset>

    <fieldset class="form">
      <legend>Estados de Processo:</legend>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div>
          <label class="label" for="new_protocol">Estado de Processo</label>
          <input type="text" id="new_step" name="new_step" />
        </div>
        <input type="hidden" name="type" value="new_step" />
        <button type="submit" class="button">
          Novo Estado de Processo
        </button>
      </form>
    </fieldset>

    <div class="title-display">
      <table class="process-table">
        <thead>
          <tr>
            <th colspan="1" scope="col">Estado de Processo</th>
            <th colspan="1" scope="col">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query4 = mysqli_query($connect, "SELECT id, step FROM Irwin ORDER BY id;");
    
          while ($row = mysqli_fetch_assoc($query4)) {
            ?>
            <tr>
              <td class="t-file"><?= $row['step'] ?></td>
              <td>
                <a href="<?= "/admin/cliente/processos/atualizar/editar?id={$_SESSION['user_id']}&cliente={$user}&processo={$process}&estado={$row['id']}" ?>" class="p-step">
                  <span>&rsaquo;</span>
                </a>
              </td>
            </tr>
            <?php
          }

          ?>
        </tbody>
      </table>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/cliente/processos?id={$_SESSION['user_id']}&cliente={$user}" ?>">
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
      <p class="form-error">Processo não encontrado</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/cliente/processos?id={$_SESSION['user_id']}&cliente={$user}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}

mysqli_close($connect);
mysqli_close($connect2);
?>

<?php include('view/footer.php'); ?>
