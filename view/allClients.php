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
    <p class="p-text">A tabela abaixo contém todos os clientes cadastrados em nosso banco de dados.</p>
    <p class="p-text">Busque pelo nome do cliente desejado no campo correspondente.</p>
    <p class="p-text">Para voltar a tabela original, limpe o campo de nome e refaça a busca.</p>
    <p class="p-text">Para consultar os processos de cada cliente, clique na seta.</p>
  </div>

  <fieldset class="form">
    <legend>Filtrar Clientes:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="name" class="label">Nome do Cliente</label>
        <input id="name" name="name" type="text" value="<?= isset($_POST['name']) ? $_POST['name'] : "" ?>" />
      </div>
      <button type="submit" class="button">
        Buscar
      </button>
    </form>
  </fieldset>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Cliente</th>
          <th colspan="1" scope="col">Processos</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
        $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
        $connect->set_charset('utf8');
  
        if (isset($_POST['name']) && strlen($_POST['name']) > 0) {
          $query = mysqli_prepare($connect, "SELECT id, name FROM Chowder WHERE name LIKE ? AND kind != 'adm' ORDER BY name;");
          
          $token = strtok($_POST['name'], ' ');
          $search = '%';
  
          while ($token) {
            $search .= $token;
            $search .= '%';
            $token = strtok(' ');
          }
  
          mysqli_stmt_bind_param($query, 's', $search);
          mysqli_stmt_execute($query);
          
          mysqli_stmt_bind_result($query, $id, $name);
          
          while(mysqli_stmt_fetch($query)) {
            ?>
            <tr>
              <td><?= $name ?></td>
              <td>
                <a href="<?= "/admin/cliente/processos?id={$_SESSION['user_id']}&cliente={$id}" ?>" class="p-step">
                  <span>&rsaquo;</span>
                </a>
              </td>
            </tr>
            <?php
          }
  
          mysqli_stmt_close($query);
        } else {
          $query = mysqli_query($connect, "SELECT id, name FROM Chowder WHERE kind != 'adm' ORDER BY name;");
  
          while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
              <td><?= $row['name'] ?></td>
              <td>
                <a href="<?= "/admin/cliente/processos?id={$_SESSION['user_id']}&cliente={$row['id']}" ?>" class="p-step">
                  <span>&rsaquo;</span>
                </a>
              </td>
            </tr>
            <?php
          }
  
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
      <a href="<?= "/admin/documentos?id={$_SESSION['user_id']}" ?>">
        <span class="arrow">Gerenciar Documentação</span>
        <span class="pointer">&rsaquo;</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
