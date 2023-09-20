<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<?php
global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
$connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
$connect->set_charset('utf8');

$query = mysqli_prepare($connect, "SELECT name, email, cellphone, cpf FROM Chowder WHERE id = ?;");
mysqli_stmt_bind_param($query, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $name, $email, $cel, $cpf);

mysqli_stmt_fetch($query);
mysqli_stmt_close($query);
mysqli_close($connect);
?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>
  
  <?php
  if (isset($error_edit_client)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_edit_client?></p>
    </div>
    <?php
  }
  ?>
  
  <fieldset class="form">
    <div class="title-display">
      <p class="p-text">Lembre-se, ao mudar seu e-mail será necessário confirmá-lo novamente.</p>
    </div>
    <legend>E-mail:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label class="label" for="edit_email">E-mail</label>
        <input type="email" id="edit_email" name="edit_email" value="<?= $email ?>" />
      </div>
      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
      <input type="hidden" name="type" value="email" />
      <button type="submit" class="button">
        Atualizar E-mail
      </button>
    </form>
  </fieldset>

  <fieldset class="form">
    <legend>Informações Pessoais:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label class="label" for="edit_name">Nome</label>
        <input type="text" id="edit_name" name="edit_name" value="<?= $name ?>" />
      </div>
      <div>
        <label class="label" for="edit_cpf">CPF</label>
        <input type="text" id="edit_cpf" name="edit_cpf" value="<?= $cpf ?>" oninput="handleCPF(this)" pattern="\d{3}.\d{3}.\d{3}-\d{2}" />
      </div>
      <div>
        <label class="label" for="edit_cel">Celular</label>
        <input type="text" id="edit_cel" name="edit_cel" value="<?= $cel ?>" oninput="handlePhone(this)" />
      </div>
      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
      <input type="hidden" name="type" value="info" />
      <button type="submit" class="button">
        Atualizar Informações
      </button>
    </form>
    <script src="/view/scripts/number-pattern.js"></script>
  </fieldset>

  <?php
  if ($_SESSION['user_avatar'] == '/view/images/new-user.png') {
    ?>
    <fieldset class="form">
      <div class="title-display">
        <p class="p-text">Escolha uma imagem no seu dispositivo e clique no botão "Enviar" para atualizar seu avatar.</p>
      </div>
      <legend>Foto de Perfil:</legend>
      <form class="file-form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
        <div class="file-input">
          <label for="avatar" class="label file-label">Selecionar Imagem</label>
          <input id="avatar" name="avatar" type="file" />
          <span id="file-name-avatar" class="file-name"></span>
        </div>
        <input type="hidden" name="type" value="new_pic" />
        <button type="submit" class="button">
          Enviar
        </button>
      </form>
      <script src="/view/scripts/file-name.js"></script>
    </fieldset>
    <?php
  } else {
    ?>
    <fieldset class="form">
      <div class="title-display">
        <p class="p-text">Para alterar seu avatar novamente, clique em "Enviar nova foto de perfil".</p>
      </div>
      <legend>Foto de Perfil:</legend>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">   
        <input type="hidden" name="type" value="old_pic" />
        <button type="submit" class="button">
          Enviar nova foto de perfil
        </button>
      </form>
    </fieldset>
    <?php
  }
  ?>

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
