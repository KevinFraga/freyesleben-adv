<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div>
    <p class="title">Parcerias de Sucesso</p>
  </div>

  <?php
  if (isset($error_partners)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_partners?></p>
    </div>
    <?php
  }

  global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
  $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
  $connect->set_charset('utf8');

  $query = mysqli_query($connect, "SELECT id, partner, logo, description FROM Mandark ORDER BY id;");

  while ($row = mysqli_fetch_array($query)) {
    ?>
    <div class="partner">
      <div class="partner-logo-container">
        <div class="partner-logo">
          <img src="<?= "/{$row['logo']}" ?>" alt="<?= "{$row['partner']}-logo" ?>" />
        </div>
      </div>

      <?php
      if (isset($_SESSION['user_kind']) && $_SESSION['user_kind'] == 'adv') {
        ?>
        <div class="partner-actions-container">
          <?php } ?>
          <div class="partner-info-container real">
            <p class="p-title"><?= $row['partner'] ?></p>
            <div class="partner-description">
              <?php
              $token = strtok($row['description'], "\r\n");

              while ($token !== false) {
                ?>
                <span><?= $token ?></span>
                <?php
                $token = strtok("\r\n");
              }

              ?>
            </div>
          </div>

          <?php
          if (isset($_SESSION['user_kind']) && $_SESSION['user_kind'] == 'adv') {
          ?>
          <div class="partner-actions">
            <div>
              <a class="p-step" href="<?= "/parceiros/editar?id={$_SESSION['user_id']}&parceiro={$row['id']}" ?>">
                <img class="icon" src="/view/images/pencil-icon.png" alt="editar" />
              </a>
            </div>
            <div>
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return confirm('Tem certeza que deseja deletar esse parceiro?');">
                <input type="hidden" name="partner" value="<?= $row['id'] ?>" />
                <button type="submit">
                  <img class="icon" src="/view/images/trash-icon.png" alt="deletar" />
                </button>
              </form>
            </div>
          </div>

        </div>
        <?php
      }
      ?>
    </div>
    <?php
  }

  mysqli_close($connect);
  ?>

  <div class="partner">
    <div class="partner-logo-container">
      <div class="partner-logo showcase">
        <p>Sua logo aqui</p>
      </div>
    </div>

    <div class="partner-info-container showcase">
      <div class="partner-description">
        <p>Divulgamos sua marca aqui.</p>
      </div>
    </div>
  </div>

  <?php
  if (isset($_SESSION['user_kind']) && $_SESSION['user_kind'] == 'adv') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="/">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Início</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/parceiros/novo?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Adicionar Parceiro</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>
</main>

<?php include('view/footer.php'); ?>
