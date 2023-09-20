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
    <p class="p-text">Localize seu processo na tabela e clique em "Ver Andamento" para continuar</p>
  </div>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Processo</th>
          <th colspan="1" scope="col">Ver Andamento</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B;
        $connect = mysqli_connect($dbHost_B, $dbUser_B, $dbPassword_B, $dbName_B);
        $connect->set_charset('utf8');
        
        $query = mysqli_prepare($connect, "SELECT m.id, b.type, m.documents_received, m.contracts_received, b.documents_needed, b.contracts_needed, m.step_id FROM Mandy m INNER JOIN Billy b ON m.process_type_id = b.id WHERE m.user_id = ? ORDER BY b.type, m.id;");
        mysqli_stmt_bind_param($query, 'i', $_SESSION['user_id']);

        mysqli_stmt_execute($query);
        mysqli_stmt_bind_result($query, $id, $type, $doc_rec, $con_rec, $doc_need, $con_need, $step);
  
        while (mysqli_stmt_fetch($query)) {
          if ($doc_rec < $doc_need) {
            $next = "/cliente/processos/enviar/documentos?id={$_SESSION['user_id']}&processo={$id}";
          } else if ($con_rec < $con_need) {
            $next = "/cliente/processos/enviar/contratos?id={$_SESSION['user_id']}&processo={$id}";
          } else if ($step > 1) {
            $next = "/cliente/processos/estado?id={$_SESSION['user_id']}&processo={$id}";
          } else {
            $next = "/cliente/processos/concluir?id={$_SESSION['user_id']}&processo={$id}";
          }
          ?>
          <tr>
            <td><?= "$type (id: $id)" ?></td>
            <td>
              <a href="<?= $next ?>" class="p-step">
                <span>&rsaquo;</span>
              </a>
            </td>
          </tr>
          <?php
        }
  
        mysqli_stmt_close($query);
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
  </div>
</main>

<?php include('view/footer.php'); ?>
