
<?php

  require_once "config.php"; // seu arquivo de conexão

  session_start();
  if (empty($_SESSION['user_id'])) {
    header("Location: login/index.html");
    exit;
  }

  $id = $_SESSION['user_id'];

  // BUSCA O NOME DO USUÁRIO NO BANCO
  $sql = "SELECT nome FROM usuarios WHERE id = ? LIMIT 1";
  $stmt = $conn->prepare($sql);
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
            <li><a href="index.html">Home</a></li>
            <li><a href="/login/">Login</a></li>
          </ul>
        </nav>
        <div class="nav-icon-container">
          <img src="img/menu.png" class="menu-button" alt="menu">
        </div>
      </div>
    </div>
  </div>
    <h2>Bem vindo(a) ao Muday!</h2>
    <p>Olá, <?= $nome ?>! Você venceu <br><strong>mais um dia?</strong></p>
    <div class="container2">
      <div class="resposta" role="group" aria-label="Resposta">
          
        <!--<button class="sim" type="button" tabindex="1"><a href="login/login.html" class="sim" role="button" tabindex="1">Sim</a></button>
        <button class="nao" type="button" tabindex="2">Não</button>-->
          
        <button class="sim" type="button" tabindex="1" id="sim">Sim</button>
        <button class="nao" type="button" tabindex="2" id="nao">Não</button>
        <p id="resposta"></p>

        <!--<script>
        const simBtn = document.getElementById('sim');
        const naoBtn = document.getElementById('nao');
        const resp = document.getElementById('resposta');
        
        simBtn.addEventListener('click', async () => {
        const r = await fetch('action_sim.php');
        const t = await r.text();
        resp.innerText = t;
        });

        naoBtn.addEventListener('click', async () => {
        const r = await fetch('consulta_tempo.php');
        const t = await r.text();
        resp.innerText = t;
        });
        </script>-->

        <script>
        const simBtn = document.getElementById('sim');
        const naoBtn = document.getElementById('nao');
        const resposta = document.getElementById('resposta');
        
        simBtn.addEventListener('click', async () => {
        const r = await fetch('action_sim.php');
        const t = await r.text();
        resposta.innerText = t;
        });
        
        naoBtn.addEventListener('click', async () => {
        const r = await fetch('consulta_tempo.php');
        const data = await r.json();
        
        if (data.error === "not_logged") {
        resposta.innerText = "Você precisa estar logado!";
        } else {
        resposta.innerHTML = `
        <span class="tempo">
        Você ficou <strong>${data.dias}</strong> dias e <strong>${data.horas}</strong> horas sem recair!
        </span>
        `;
        }
        });
        </script>
          
      </div>
   </div>
      <script>        
        const navbar = document.querySelector('.navbar');
        const menuButton = document.querySelector('.menu-button');
        if (menuButton && navbar) {
          menuButton.addEventListener('click', () => {
          navbar.classList.toggle('show-menu');
          });
        }
      </script>
    </div>
  </body>
</html>



