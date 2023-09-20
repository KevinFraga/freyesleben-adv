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

$process_id = (int) htmlspecialchars($_GET['processo']);

$query3 = mysqli_prepare($connect, "SELECT type FROM Billy WHERE id = ?;");
mysqli_stmt_bind_param($query3, 'i', $process_id);
mysqli_stmt_execute($query3);

mysqli_stmt_bind_result($query3, $process_type);
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
      <p class="p-text">Selecione um tipo de documento que será solicitado para a abertura deste processo na lista abaixo e clique em "Adicionar".</p>
      <p class="p-text">Defina tanto os documentos pessoais que o cliente precisará enviar quanto os contratos em branco que precisará preencher.</p>
      <p class="p-text">Adicione quantos itens forem necessários.</p>
      <p class="p-text">Para remover algum registro, clique no ícone de lixeira correspondente.</p>
    </div>
    
    <div class="title-display">
      <p class="title"><?= $process_type ?></p>
    </div>
    
    <?php
    if (isset($error_new_necessary_file)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_new_necessary_file?></p>
      </div>
      <?php
    }
    ?>

    <div class="form">
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="input-holder">
          <label for="fileType" class="label">Documentos</label>
          <select name="fileType" id="fileType">
            <?php
            $query = mysqli_query($connect2, "SELECT id, type FROM Eustace ORDER BY type;");
  
            while ($row = mysqli_fetch_assoc($query)) {
              ?>
              <option value="<?= $row['id'] ?>">
                <?= $row['type'] ?>
              </option>
              <?php
            }
            
            ?>
          </select>
        </div>
        <input type="hidden" name="type" value="insert" />
        <button type="submit" class="button">
          Adicionar
        </button>
      </form>
    </div>

    <div class="title-display">
      <table class="process-table">
        <thead>
          <tr>
            <th colspan="1" scope="col">Documentação</th>
            <th colspan="1" scope="col">Remover</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query2 = mysqli_prepare($connect, "SELECT file_type_id FROM Grim WHERE process_type_id = ? ORDER BY file_type_id;");
          mysqli_stmt_bind_param($query2, 'i', $process_id);

          mysqli_stmt_execute($query2);
          mysqli_stmt_bind_result($query2, $file_type_id);
  
          while (mysqli_stmt_fetch($query2)) {
            $query4 = mysqli_prepare($connect2, "SELECT type FROM Eustace WHERE id = ?;");
            mysqli_stmt_bind_param($query4, 'i', $file_type_id);
            mysqli_execute($query4);

            mysqli_stmt_bind_result($query4, $file_type);
            mysqli_stmt_fetch($query4);
            mysqli_stmt_close($query4);
            ?>
            <tr>
              <td><?= $file_type ?></td>
              <td>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                  <input type="hidden" name="fileType" value="<?= $file_type_id ?>" />
                  <input type="hidden" name="type" value="delete" />
                  <button type="submit">
                    <img class="icon" src="/view/images/trash-icon.png" alt="deletar" />
                  </button>
                </form>
              </td>
            </tr>
            <?php
          }
  
          mysqli_stmt_close($query2);
          
          ?>
        </tbody>
      </table>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/admin/documentos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Documentação</span>
          <span class="pointer">&rsaquo;</span>
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
        <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/admin/documentos?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Gerenciar Documentação</span>
          <span class="pointer">&rsaquo;</span>
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
