<?php require_once('middleware/session.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Freyesleben Advogados Associados, especialistas em direito aeronáutico, civil, de família, de sucessão, do trabalho, empresarial, recuperação judicial, desportivo, AERUS, FGTS, desportivo, penal e previdenciário.">
  <title>Freyesleben Advogados Associados</title>
  <link rel="stylesheet" href="/view/styles/app.css">
  <link rel="stylesheet" href="/view/styles/header.css">
  <link rel="stylesheet" href="/view/styles/footer.css">
  <link rel="stylesheet" href="/view/styles/hub.css">
  <link rel="stylesheet" href="/view/styles/text.css">
  <link rel="stylesheet" href="/view/styles/arrow.css">
  <link rel="stylesheet" href="/view/styles/input.css">
  <link rel="stylesheet" href="/view/styles/container.css">
  <link rel="stylesheet" href="/view/styles/table.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="/view/images/favicon.ico" type="image/x-icon">
</head>

<body>
  <header id="header">
    <div class="NavBar">
      <div class="menu close" id="hamburger-lines">
        <div class="hamburger-lines">
          <span class="line line1"></span>
          <span class="line line2"></span>
          <span class="line line3"></span>
        </div>
      </div>
      <div class="logo-container">
        <a href="/">
          <img src="/view/images/logo.png" alt="logo" class="logo" />
        </a>
      </div>
      <div class="avatar-container">
        <a href="<?= isset($_SESSION['user_name']) ? "/cliente?id={$_SESSION['user_id']}" : "/login" ?>">
          <img src="<?= isset($_SESSION['user_name']) ? $_SESSION['user_avatar'] : "/view/images/new-user.png" ?>" alt="login" id="login" />
        </a>
      </div>
    </div>
    <nav class="menu close">
      <ul class="menu-items">
        <a href="<?= isset($_SESSION['user_name']) ? "/cliente?id={$_SESSION['user_id']}" : "/login" ?>">
          <li>Minha Conta</li>
        </a>
        <a href="/quem_somos">
          <li>Quem Somos</li>
        </a>
        <li id="features">Ações em Destaque</li>
        <ul id="featurer" class="unseen">
          <a href="/causas#fgts">
            <li class="featured">Revisão de Valores FGTS</li>
          </a>
          <a href="/causas#emprestimos_AERUS">
            <li class="featured">
              Ação Monitória Empréstimos AERUS
            </li>
          </a>
          <a href="/causas#inventario_AERUS">
            <li class="featured">
              Ação Inventário: Benefício AERUS
            </li>
          </a>
          <a href="/causas#rateio">
            <li class="featured">Recebimento de Rateios</li>
          </a>
        </ul>
        <a href="/parceiros">
          <li>Nossos Parceiros</li>
        </a>
        <a href="/depoimentos">
          <li>Depoimentos</li>
        </a>
        <a href="/blog">
          <li>Blog</li>
        </a>
        <a href="/lives">
          <li>Nossas Lives</li>
        </a>
        <a href="/contato">
          <li>Fale Conosco</li>
        </a>
        <a href="/privacidade">
          <li>Política de Privacidade</li>
        </a>
        <a href="/?logout">
          <li>Sair</li>
        </a>
      </ul>
    </nav>
  </header>
  <script src="/view/scripts/hamburger-menu.js"></script>
