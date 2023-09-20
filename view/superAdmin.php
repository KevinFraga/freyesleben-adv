<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
$connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
$connect->set_charset('utf8');
?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>

  <div class="title-display">
    <p class="p-text">Escolha o usuário e a função que deseja atribuí-lo.</p>
    <p class="p-text">Para retirar a função, clique no ícone de remover ao lado.</p>
  </div>
  
  <?php
    if (isset($error_super)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_super ?></p>
    </div>
    <?php
  }
  ?>
  
  <fieldset class="form">
    <legend>Atribuir Função:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="user" class="label">Usuário</label>
        <select id="user" name="user">
          <?php
          $query = mysqli_query($connect, "SELECT id, name FROM Chowder WHERE kind = 'usr' ORDER BY name;");
          while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div>
        <label for="kind" class="label">Função</label>
        <select id="kind" name="kind">
          <option value="adv">Advogado</option>
          <option value="ctd">Contador</option>
        </select>
      </div>
      <input type="hidden" name="type" value="in">
      <button type="submit" class="button">
        Promover
      </button>
    </form>
  </fieldset>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Advogados</th>
          <th colspan="1" scope="col">Remover</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query2 = mysqli_query($connect, "SELECT id, name FROM Chowder WHERE kind = 'adv' ORDER BY name;");
  
        while ($row = mysqli_fetch_assoc($query2)) {
          ?>
          <tr>
            <td class="t-file"><?= $row['name'] ?></td>
            <td class="t-title">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return confirm('Tem certeza que deseja remover a função desse usuário?');">
                <input type="hidden" name="user" value="<?= $row['id'] ?>" />
                <input type="hidden" name="type" value="out">
                <button type="submit">
                  <img class="icon" src="/view/images/trash-icon.png" alt="remover" />
                </button>
              </form>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Contadores</th>
          <th colspan="1" scope="col">Remover</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query3 = mysqli_query($connect, "SELECT id, name FROM Chowder WHERE kind = 'ctd' ORDER BY name;");
  
        while ($row = mysqli_fetch_assoc($query3)) {
          ?>
          <tr>
            <td class="t-file"><?= $row['name'] ?></td>
            <td class="t-title">
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return confirm('Tem certeza que deseja remover a função desse usuário?');">
                <input type="hidden" name="user" value="<?= $row['id'] ?>" />
                <input type="hidden" name="type" value="out">
                <button type="submit">
                  <img class="icon" src="/view/images/trash-icon.png" alt="remover" />
                </button>
              </form>
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
      <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Voltar</span>
      </a>
    </div>
  </div>
</main>

<?php
mysqli_close($connect);
?>

<?php include('view/footer.php'); ?>
