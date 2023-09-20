<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
$connect2 = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
$connect2->set_charset('utf8');

global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
$connect3 = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
$connect3->set_charset('utf8');

$user = (int) htmlspecialchars($_GET['cliente']);
$process = (int) htmlspecialchars($_GET['processo']);

$query3 = mysqli_prepare($connect, "SELECT b.type FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ? AND m.user_id = ?;");
mysqli_stmt_bind_param($query3, 'ii', $process, $user);
mysqli_stmt_execute($query3);

mysqli_stmt_bind_result($query3, $process_type);
mysqli_stmt_fetch($query3);
mysqli_stmt_close($query3);

$query4 = mysqli_prepare($connect3, "SELECT name FROM Chowder WHERE id = ?;");
mysqli_stmt_bind_param($query4, 'i', $user);
mysqli_stmt_execute($query4);

mysqli_stmt_bind_result($query4, $client);
mysqli_stmt_fetch($query4);
mysqli_stmt_close($query4);
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
      <p class="p-text">Faça o download dos documentos enviados pelo cliente clicando no ícone de documento correspondente.</p>
    </div>

    <div class="title-display">
      <p class="title"><?= $client ?></p>
    </div>
    
    <div class="title-display">
      <p class="title"><?= $process_type ?></p>
    </div>

    <?php
    $query = mysqli_prepare($connect, "SELECT g.file_type_id FROM Mandy m INNER JOIN Grim g ON m.process_type_id = g.process_type_id WHERE m.user_id = ? AND m.id = ? ORDER BY g.file_type_id;");
    mysqli_stmt_bind_param($query, 'ii', $user, $process);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $file_type_id);

    while (mysqli_stmt_fetch($query)) {
      $query5 = mysqli_prepare($connect2, "SELECT type FROM Eustace WHERE id = ?;");
      mysqli_stmt_bind_param($query5, 'i', $file_type_id);
      mysqli_stmt_execute($query5);

      mysqli_stmt_bind_result($query5, $file_type);
      mysqli_stmt_fetch($query5);
      mysqli_stmt_close($query5);
      
      $query2 = mysqli_prepare($connect2, "SELECT path FROM Courage WHERE user_id = ? AND process_id = ? AND file_type_id = ?;");
      mysqli_stmt_bind_param($query2, 'iii', $user, $process, $file_type_id);
      mysqli_stmt_execute($query2);
      mysqli_stmt_bind_result($query2, $file_path);

      if (!mysqli_stmt_fetch($query2)) {
        ?>
        <div class="document-container not-received">
          <div class="d-title center">    
            <p class="step-text"><?= $file_type ?></p>
          </div>

          <div class="d-file">
            <p class="form-error">Documentação Não Recebida</p>
          </div>
        </div>
        <?php
      } else {
        ?>
        <div class="document-container received">
          <div class="d-title center">    
            <p class="step-text"><?= $file_type ?></p>
          </div>
          
          <div class="d-status center">
            <p class="step-text">Documentação Recebida</p>
          </div>

          <div class="d-action">
            <div class="form">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="hidden" name="user_id" value="<?= $user ?>" />
                <input type="hidden" name="process_id" value="<?= $process ?>" />
                <input type="hidden" name="file_type_id" value="<?= $file_type_id ?>" />
                <button type="submit">
                  <img class="big-icon" src="/view/images/blank-icon.png" alt="Download" />
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php
      }

      mysqli_stmt_close($query2);
    }

    mysqli_stmt_close($query);
    ?>

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
mysqli_close($connect3);
?>

<?php include('view/footer.php'); ?>
