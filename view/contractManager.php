<?php require_once('model/database.php'); ?>
<?php include('view/header.php'); ?>
<?php include('view/backlogo.php'); ?>

<main class="page-container">
  <?php $user_first_name = strtok($_SESSION['user_name'], ' '); ?>
  <h1 class="user-name">
    <?= "Olá, {$user_first_name}" ?>
  </h1>

  <div class="title-display">
    <p class="p-text">Nomeie o tipo de contrato que os clientes deverão baixar ao iniciarem um processo e cadastre-o.</p>
    <p class="p-text">Em seguida, localize-o na tabela abaixo e faça o upload do modelo em branco.</p>
    <p class="p-text">Para substituir o arquivo, clique no ícone de reciclagem correspondente para deletá-lo e então refaça o upload.</p>
    <p class="p-text">Para editar o nome do registro, clique na seta.</p>
  </div>
  
  <?php
  if (isset($error_new_contract)) {
    ?> 
    <div class="title-display">
      <p class="form-error"><?= $error_new_contract?></p>
    </div>
    <?php
  }
  ?>

  <fieldset class="form">
    <legend>Novo Contrato:</legend>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
      <div>
        <label for="fileType" class="label">Nome do Contrato</label>
        <input id="fileType" name="fileType" type="text" />
      </div>
      <input type="hidden" name="type" value="create" />
      <button type="submit" class="button">
        Cadastrar
      </button>
    </form>
  </fieldset>

  <div class="title-display">
    <table class="process-table">
      <thead>
        <tr>
          <th scope="col">Contrato</th>
          <th scope="col">Arquivo em Branco</th>
          <th scope="col">Editar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        global $dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C;
        $connect = mysqli_connect($dbHost_C, $dbUser_C, $dbPassword_C, $dbName_C);
        $connect->set_charset('utf8');

        $query = mysqli_query($connect, "SELECT e.id, e.type, m.path FROM Eustace e LEFT JOIN Muriel m ON m.file_type_id = e.id WHERE e.contract = TRUE ORDER BY e.type;");
  
        while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td class="t-title"><?= $row['type'] ?></td>
            <td class="t-file">
              <?php
              if (isset($row['path'])) {
                ?>
                <div>
                  <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <input type="hidden" name="fileType" value="<?= $row['id'] ?>" />
                    <input type="hidden" name="type" value="delete" />
                    <button type="submit">
                      <img class="big-icon" src="/view/images/replace-icon.png" alt="substituir" />
                    </button>
                  </form>
                </div>
                <?php
              } else {
                ?>
                <div class="file-input">
                  <form class="file-form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                    <div class="file-input">
                      <label class="file-label" for="<?= "contract{$row['id']}" ?>">Selecionar Documento</label>
                      <input id="<?= "contract{$row['id']}" ?>" name="contract" type="file" />
                      <span id="<?= "name{$row['id']}" ?>" class="file-name"></span>
                    </div>
                    <input type="hidden" name="fileType" value="<?= $row['id'] ?>" />
                    <input type="hidden" name="type" value="insert" />
                    <button type="submit" class="button">
                      Enviar
                    </button>
                  </form>
                  
                  <script>
                    function updateName() {
                      const input = document.getElementById("<?= "contract{$row['id']}" ?>");
                      const target = document.getElementById("<?= "name{$row['id']}" ?>");
                      target.innerHTML = input.files[0].name;
                    }
                    
                    document.getElementById("<?= "contract{$row['id']}" ?>").addEventListener('change', updateName);
                  </script>
                </div>
                <?php
              }
              ?>
            </td>
            <td>
              <a href="<?= "/admin/documentos/editar?id={$_SESSION['user_id']}&documento={$row['id']}" ?>" class="p-step">
                <span>&rsaquo;</span>
              </a>
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
      <a href="<?= "/cliente?id={$_SESSION['user_id']}" ?>">
        <span class="pointer">&lsaquo;</span>
        <span class="arrow">Voltar</span>
      </a>
    </div>
    <div class="func-col">
      <a href="<?= "/admin/processos?id={$_SESSION['user_id']}" ?>">
        <span class="arrow">Gerenciar Processos</span>
        <span class="pointer">&rsaquo;</span>
      </a>
    </div>
  </div>
</main>

<?php include('view/footer.php'); ?>
