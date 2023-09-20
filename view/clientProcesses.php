<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
$connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
$connect->set_charset('utf8');

global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect2 = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect2->set_charset('utf8');

$user = (int) htmlspecialchars($_GET['cliente']);

$query2 = mysqli_prepare($connect, "SELECT name FROM Chowder WHERE id = ?;");
mysqli_stmt_bind_param($query2, 'i', $user);
mysqli_stmt_execute($query2);

mysqli_stmt_bind_result($query2, $user_name);
mysqli_stmt_fetch($query2);
mysqli_stmt_close($query2);
?>

<?php
if (isset($user_name)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>

    <div class="title-display">
      <p class="p-text">A tabela abaixo contém todos os processos solicitados por este cliente.</p>
      <p class="p-text">Para consultar a documentação de cada processo, clique em Documentação.</p>
      <p class="p-text">Para atualizar o estado de cada processo, clique em Atualizar.</p>
    </div>
    
    <div class="title-display">
      <p class="title"><?= $user_name ?></p>
    </div>
    
    <div class="title-display">
      <table class="process-table">
        <thead>
          <tr>
            <th colspan="1" scope="col">Processo</th>
            <th colspan="1" scope="col">Documentação</th>
            <th colspan="1" scope="col">Atualizar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_prepare($connect2, "SELECT m.id, b.type FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.user_id = ? ORDER BY b.type, m.id;");
          mysqli_stmt_bind_param($query, 'i', $user);
    
          mysqli_stmt_execute($query);
          mysqli_stmt_bind_result($query, $process, $processType);
          
          while (mysqli_stmt_fetch($query)) {
            ?>
            <tr>
              <td><?= "$processType (id: $process)" ?></td>
              <td>
                <a href="<?= "/admin/cliente/processos/documentos?id={$_SESSION['user_id']}&cliente={$user}&processo={$process}" ?>" class="p-step">
                  <img class="big-icon" src="/view/images/blank-icon.png" alt="document-icon" />
                </a>
              </td>
              <td>
                <a href="<?= "/admin/cliente/processos/atualizar?id={$_SESSION['user_id']}&cliente={$user}&processo={$process}" ?>" class="p-step">
                  <span>&rsaquo;</span>
                </a>
              </td>
            </tr>
            <?php
          }
    
          mysqli_stmt_close($query);
          mysqli_close($connect);
          mysqli_close($connect2);
          ?>
        </tbody>
      </table>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/cliente?id={$_SESSION['user_id']}" ?>">
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
      <p class="form-error">Cliente não encontrado</p>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/cliente?id={$_SESSION['user_id']}" ?>">
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
