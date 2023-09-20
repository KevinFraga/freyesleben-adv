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

$process = (int) htmlspecialchars($_GET['processo']);

$query3 = mysqli_prepare($connect, "SELECT b.type FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ? AND m.user_id = ?;");
mysqli_stmt_bind_param($query3, 'ii', $process, $_SESSION['user_id']);
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
      <p class="p-text">Faça o download do documento em branco clicando no ícone acima do nome do arquivo que deseja baixar.</p>
      <p class="p-text">Para devolvê-lo preenchido e assinado após salvá-lo no seu dispositivo, clique em "Selecionar Documento" e "Enviar".</p>
      <p class="p-text">A documentação deve ser enviada em PDF, com tamanho máximo de 5MB.</p>
      <p class="p-text">Envie todos os documentos solicitados para concluir sua solicitação de abertura do seu processo.</p>
    </div>

    <div class="title-display">
      <p class="title"><?= $process_type ?></p>
    </div>
    
    <?php
    if (isset($error_file_upload)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_file_upload?></p>
      </div>
      <?php
    }

    $query = mysqli_prepare($connect, "SELECT g.file_type_id, m.contracts_received, b.contracts_needed FROM Mandy m INNER JOIN Grim g ON m.process_type_id = g.process_type_id INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.user_id = ? AND m.id = ? ORDER BY g.file_type_id;");
    mysqli_stmt_bind_param($query, 'ii', $_SESSION['user_id'], $process);

    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $file_type_id, $received, $needed);
    
    while (mysqli_stmt_fetch($query)) {
      $query4 = mysqli_prepare($connect2, "SELECT type, contract FROM Eustace WHERE id = ?;");
      mysqli_stmt_bind_param($query4, 'i', $file_type_id);
      mysqli_stmt_execute($query4);

      mysqli_stmt_bind_result($query4, $file_type, $is_contract);
      mysqli_stmt_fetch($query4);
      mysqli_stmt_close($query4);

      if ($is_contract) {
        $query2 = mysqli_prepare($connect2, "SELECT path FROM Courage WHERE user_id = ? AND process_id = ? AND file_type_id = ?;");
        mysqli_stmt_bind_param($query2, 'iii', $_SESSION['user_id'], $process, $file_type_id);
        
        mysqli_stmt_execute($query2);
        mysqli_stmt_bind_result($query2, $file_path);
  
        if (!mysqli_stmt_fetch($query2)) {
          ?>
          <div class="document-container not-received">
            <div class="d-title">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="hidden" name="file_type_id" value="<?= $file_type_id ?>" />
                <input type="hidden" name="type" value="download" />
                <button type="submit">
                  <img class="big-icon" src="/view/images/blank-icon.png" alt="branco" />
                </button>
              </form>
              
              <div class="center">
                <p class="step-text"><?= $file_type ?></p>
              </div>
            </div>
          
            <div class="d-file">
              <form class="file-form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                <div class="file-input">
                  <label for="<?= "file-$file_type_id" ?>" class="label file-label">Selecionar Documento</label>
                  <input id="<?= "file-$file_type_id" ?>" name="file" type="file" />
                  <span id="<?= "name-$file_type_id" ?>" class="file-name"></span>
                </div>
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
                <input type="hidden" name="process_id" value="<?= $process ?>" />
                <input type="hidden" name="file_type_id" value="<?= $file_type_id ?>" />
                <input type="hidden" name="type" value="upload" />
                <button type="submit" class="button">
                  Enviar
                </button>
              </form>
              
              <script>
                function updateName() {
                  const input = document.getElementById("<?= "file-$file_type_id" ?>");
                  const target = document.getElementById("<?= "name-$file_type_id" ?>");
                  target.innerHTML = input.files[0].name;
                }
                
                document.getElementById("<?= "file-$file_type_id" ?>").addEventListener('change', updateName);
              </script>
            </div>
          </div>
          <?php
        } else {
          ?>
          <div class="document-container received">
            <div class="d-title">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="hidden" name="file_type_id" value="<?= $file_type_id ?>" />
                <input type="hidden" name="type" value="download" />
                <button type="submit">
                  <img class="big-icon" src="/view/images/blank-icon.png" alt="branco" />
                </button>
              </form>
              
              <div class="center">
                <p class="step-text"><?= $file_type ?></p>
              </div>
            </div>
          
            <div class="d-status center">
              <p class="step-text">Documentação Recebida</p>
            </div>
  
            <div class="d-action">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
                <input type="hidden" name="process_id" value="<?= $process ?>" />
                <input type="hidden" name="file_type_id" value="<?= $file_type_id ?>" />
                <input type="hidden" name="type" value="delete" />
                <button type="submit">
                  <img class="big-icon" src="/view/images/replace-icon.png" alt="Substituir" />
                </button>
              </form>
            </div>
          </div>
          <?php
        }

        mysqli_stmt_close($query2);
      }
    }

    mysqli_stmt_close($query);

    if ($needed == 0) {
      ?>
      <div class="important">
        <p>Nenhum contrato cadastrado nesse processo</span>
      </div>
      <?php
    }
    ?>

    <div class="info-container">
      <div class="title-display">
        <p class="step-text">Há duas formas de preencher e assinar os documentos:</p>
        <br>
        <p class="step-text">1) Digitalmente, via <a href="https://assinador.iti.br/assinatura/index.xhtml" target="_blank">gov.br</a></p>
        <p class="step-text">Para instruções, <u id="more-info">clique aqui</u></p>
        <br>
        <p class="step-text">2) Em papel, via impressora.</p>
        <p class="step-text">Imprima, preencha e assine, depois digitalize e salve em seu dispositivo no formato PDF.</p>
        <br>
        <p class="step-text">Anexe o arquivo salvo em "Selecionar Documento" e clique em "Enviar".</p>
      </div>
    </div>

    <script src="/view/scripts/more-info.js"></script>

    <div class="more-info off" id="more-info-bubble">
      <div class="title-display center">
        <p class="p-text">Após preencher o documento em branco no Word, abra o link que consta nas instruções para logar no seu gov.br e siga as orientações da plataforma.</p>
        <p class="p-text">Baixe o documento assinado e salve no seu dispositivo.</p>
        <p class="p-text">Em seguida, anexe este arquivo em "Selecionar Documento" e clique em "Enviar".</p>
      </div>
    </div>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/cliente/processos/enviar/documentos?id={$_SESSION['user_id']}&processo={$process}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <?php
      if (isset($received) && isset($needed) && $received == $needed) {
        ?>
        <div class="func-col">
          <a href="<?= "/cliente/processos/concluir?id={$_SESSION['user_id']}&processo={$process}" ?>">
            <span class="arrow">Concluir</span>
            <span class="pointer">&rsaquo;</span>
          </a>
        </div>
        <?php
      } else {
        ?>
        <div class="func-col locked">
          <a>
            <span class="arrow">Envie todos para continuar</span>
            <span class="pointer">&rsaquo;</span>
          </a>
        </div>
        <?php
      }
      ?>
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
        <a href="<?= "/cliente/processos?id={$_SESSION['user_id']}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col locked">
        <a>
          <span class="arrow">Envie todos para continuar</span>
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
