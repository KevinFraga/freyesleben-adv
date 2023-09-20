<?php require_once('middleware/session.php'); ?>
<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <div class="title-display">
    <p class="title">Blog do Advogado</p>
    <p class="subtitle">O que penso sobre...</p>
  </div>

  <?php
  if (isset($error_blog)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_blog?></p>
    </div>
    <?php
  }

  global $dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A;
  $connect = mysqli_connect($dbHost_A, $dbUser_A, $dbPassword_A, $dbName_A);
  $connect->set_charset('utf8');

  global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
  $connect2 = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
  $connect2->set_charset('utf8');
  
  $query = mysqli_query($connect2, "SELECT id, user_id, title, text, DATE_FORMAT(created_at, '%d.%m.%y  %H:%i') AS created_at, DATE_FORMAT(updated_at, '%d.%m.%y  %H:%i') AS updated_at FROM DeeDee ORDER BY created_at DESC;");
  
  while ($row = mysqli_fetch_assoc($query)) {
    ?>
    <div class="post">
      <div class="p-head">
        <?php
        $query2 = mysqli_prepare($connect, "SELECT name, avatar FROM Chowder WHERE id = ?;");
        mysqli_stmt_bind_param($query2, 'i', $row['user_id']);
        mysqli_execute($query2);

        mysqli_stmt_bind_result($query2, $full_name, $avatar);
        mysqli_stmt_fetch($query2);
        mysqli_stmt_close($query2);

        $token = strtok($full_name, " ");
        $first_name = $token;

        while ($token) {
          $last_name = $token;
          $token = strtok(" ");
        }

        $name = "$first_name $last_name";
        ?>
        <div class="p-img">
          <img src="<?= "/{$avatar}" ?>" alt="<?= $name ?>" />
          <p class="p-name"><?= $name ?></p>
        </div>
        <div class="p-data">
          <p class="post-title"><?= $row['title'] ?></p>
          <div class="p-info">
            <p>Criado em: <?= $row['created_at'] ?></p>
            <?php
            if ($row['updated_at'] != $row['created_at']) {
              ?>
              <p>Modificado em: <?= $row['updated_at'] ?></p>
              <?php
            }
            ?>
          </div>
        </div>
      </div>

      <div>
        <?php
        $string = $row['text'];
        $token = strtok($string, "\r\n");

        while ($token) {
          ?>
          <p class="p-text"><?= $token ?></p>
          <?php
          $token = strtok("\r\n");
        }

        ?>
      </div>

      <?php
      if (isset($_SESSION['user_id']) && ($row['user_id'] == $_SESSION['user_id'] || $_SESSION['user_kind'] == 'adv')) {
        ?>
        <div class="partner-actions">
          <div>
            <a class="p-step" href="<?= "/blog/editar?id={$_SESSION['user_id']}&post={$row['id']}" ?>">
              <img class="icon" src="/view/images/pencil-icon.png" alt="editar" />
            </a>
          </div>
          <div>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return confirm('Tem certeza que deseja deletar esse post?');">
              <input type="hidden" name="post_id" value="<?= $row['id'] ?>" />
              <button type="submit">
                <img class="icon" src="/view/images/trash-icon.png" alt="deletar" />
              </button>
            </form>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <?php
  }

  mysqli_close($connect);

  if (isset($_SESSION['user_kind']) && $_SESSION['user_kind'] == 'admin') {
    ?>
    <div class="func-row">
      <div class="func-col">
        <a href="/">
          <span class="pointer">&lsaquo;</span>
          <span class="arrow">Início</span>
        </a>
      </div>
      <div class="func-col">
        <a href="<?= "/blog/novo?id={$_SESSION['user_id']}" ?>">
          <span class="arrow">Novo Post</span>
          <span class="pointer">&rsaquo;</span>
        </a>
      </div>
    </div>
    <?php
  }
  ?>
</main>

<?php include('view/footer.php'); ?>
