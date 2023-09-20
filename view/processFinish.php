<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
$connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
$connect->set_charset('utf8');

$process = (int) htmlspecialchars($_GET['processo']);

$query = mysqli_prepare($connect, "SELECT m.email_sent, m.documents_received, m.contracts_received, b.documents_needed, b.contracts_needed FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.id = ? AND m.user_id = ?;");
mysqli_stmt_bind_param($query, 'ii', $process, $_SESSION['user_id']);
mysqli_stmt_execute($query);

mysqli_stmt_bind_result($query, $email_sent, $doc_rec, $con_rec, $doc_need, $con_need);
mysqli_stmt_fetch($query);

mysqli_stmt_close($query);
mysqli_close($connect);
?>

<?php
if (isset($email_sent)) {
  ?>
  <main class="page-container">
    <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
    <h1 class="user-name">
      <?= "Olá, {$user_first_name}" ?>
    </h1>
    
    <?php
    if ($doc_rec == $doc_need && $con_rec == $con_need) {
      ?>
      <div>
        <div class="important">
          <p class="cv-title">Parabéns!</p>
          <p class="p-text">Você completou a primeira etapa de abertura de processo.</p>
          <p class="p-text">Se aplicável, o boleto de cobrança das taxas judiciárias será enviado em breve.</p>
          <p class="p-text">Deverá ser pago e o comprovante enviado por e-mail ou WhatsApp para que possamos dar entrada na petição.</p>
          <p class="p-text">Verifique regularmente sua caixa de entrada para atualizações sobre o processo.</p>
          <p class="p-text">Agradecemos a confiança depositada em nosso escritório e esperamos poder retribuir com o êxito.</p>
          <p class="cv-title">Freyesleben Advogados Associados.</p>
        </div>
      </div>
      <?php
    } else {
      ?>
      <div>
        <div class="important">
        <p class="form-error">Envie todos os documentos solicitados para concluir a solicitação do seu processo.</p>
        </div>
      </div>
      <?php
    }
    ?>

    <?php
    if (!$email_sent && $doc_rec == $doc_need && $con_rec == $con_need) {
      ?>
      <form id="emailer" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <input type="hidden" name="process" value="<?= $process ?>">
        <button type="submit"></button>
      </form>
      <script src="/view/scripts/emailer.js"></script>
      <?php
    }
    ?>

    <?php
    if (isset($error_finish)) {
      ?> 
      <div class="title-display">
        <p class="form-error"><?= $error_finish?></p>
      </div>
      <?php
    }
    ?>

    <div class="func-row">
      <div class="func-col">
        <a href="<?= "/cliente/processos/enviar/contratos?id={$_SESSION['user_id']}&processo={$process}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Área Exclusiva</span>
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
        <a href="<?= "/cliente/processos/enviar/contratos?id={$_SESSION['user_id']}&processo={$process}" ?>">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Voltar</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Área Exclusiva</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
  </main>
  <?php
}
?>

<?php include('view/footer.php'); ?>
