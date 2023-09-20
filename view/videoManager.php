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
    <p class="p-text">Copie a URL do vídeo no youtube que queira exibir.</p>
    <p class="p-text">Selecione qual vídeo será exibido clicando na coluna ao lado.</p>
  </div>
  
  <?php
    if (isset($error_video)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_video?></p>
    </div>
    <?php
  }
  ?>
  
  <fieldset class="form">
    <legend>Adicionar Vídeo:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="videoTitle" class="label">Título do Vídeo</label>
        <input id="videoTitle" name="videoTitle" type="text" />
      </div>
      <div>
        <label for="videoURL" class="label">URL do Vídeo</label>
        <input id="videoURL" name="videoURL" type="text" />
      </div>
      <input type="hidden" name="type" value="new">
      <button type="submit" class="button">
        Salvar
      </button>
    </form>
  </fieldset>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th colspan="1" scope="col">Vídeo</th>
          <th colspan="1" scope="col">Selecionado</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E;
        $connect = mysqli_connect($dbHost_E, $dbUser_E, $dbPassword_E, $dbName_E);
        $connect->set_charset('utf8');

        $query = mysqli_query($connect, "SELECT id, title, selected FROM SpaceGhost ORDER BY id;");
  
        while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td class="t-file"><?= $row['title'] ?></td>
            <td class="t-title">
              <?php
              if ($row['selected']) {
                ?>
                <span class="p-title">&check;</span>
                <?php
              } else {
                ?>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                  <input type="hidden" name="video_id" value="<?= $row['id'] ?>" />
                  <input type="hidden" name="type" value="select">
                  <button type="submit">
                    <img class="big-icon" src="/view/images/replace-icon.png" alt="selecionar" />
                  </button>
                </form>
                <?php
              }
              ?>
            </td>
          </tr>
          <?php
        }
  
        mysqli_close($connect);
        ?>
      </tbody>
    </table>
  </div>

  <div class="func-row">
    <div class="func-col">
      <a href="/lives">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Voltar</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
