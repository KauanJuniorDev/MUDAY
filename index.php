<?php
session_start();
include_once('cadastro/config.php');
if (empty($_SESSION['user_id'])) {
    header("Location: login/index.html");
    exit;
  }

  $id = $_SESSION['user_id'];

  // BUSCA O NOME DO USUÁRIO NO BANCO
  $sql = "SELECT nome FROM usuarios WHERE id = ? LIMIT 1";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  $nome = $user['nome'];

?>

<html lang="pt-BR">  
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUDAY</title>
    <link rel="shortcut icon" href="img/caneta-calendario.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/globals.css">
  </head>
  <body>
    <div class="navbar show-menu">
      <div class="header-inner-content">
        <h1 class="logo">MU<span>DAY</span></h1>
        <nav>
          <ul>
            <li><a href="index.php">Home</a></li>
			      <li><a href="login/index.html">Login</a></li>
          </ul>
        </nav>
        <div class="nav-icon-container">
          <img src="img/menu.png" class="menu-button" alt="menu">
        </div>
      </div>
    </div>
  
    <p>Olá <?= $nome ?>! <br>Você venceu <strong>mais um dia?</strong></p>

    <div class="container2">
      <div class="resposta" role="group" aria-label="Resposta">
          
        <!--<button class="sim" type="button" tabindex="1"><a href="login/login.html" class="sim" role="button" tabindex="1">Sim</a></button>
        <button class="nao" type="button" tabindex="2">Não</button>-->
          
        <button class="sim" type="button" tabindex="1" id="sim">Sim</button>
        <button class="nao" type="button" tabindex="2" id="nao">Não</button>
        <p id="resposta" class="resposta"></p>
      </div>
    </div>
      

    <script>
      const simBtn = document.getElementById('sim');
      const naoBtn = document.getElementById('nao');
      const resposta = document.getElementById('resposta');

      // BOTÃO "SIM"
      simBtn.addEventListener('click', async () => {
        const r = await fetch('action_sim.php', {method: 'POST'});
        const t = await r.text();
        resposta.innerText = t;
      });

      // BOTÃO "NÃO"
      naoBtn.addEventListener('click', async () => {
        const r = await fetch('consulta_tempo.php', {method: 'POST'});

        let data;
        try {
          data = await r.json();
        } catch (error) {
          resposta.innerText = "Erro ao processar a resposta do servidor.";
          return;
        }

        if (data.error === "not_logged") {
          resposta.innerText = "Você precisa estar logado!";
        } else {
          resposta.innerHTML = `
            <span class="tempo">
              Você ficou <strong>${data.dias}</strong>d <strong>${data.horas}</strong>h <strong>${data.minutos}</strong>m <strong>${data.segundos}</strong>s sem recair!
            </span>`;
        }
      });
  
      const navbar = document.querySelector('.navbar');
      const menuButton = document.querySelector('.menu-button');
      if (menuButton && navbar) {
        menuButton.addEventListener('click', () => {
          navbar.classList.toggle('show-menu');
          });
        }
    </script>
  </body>
</html>
