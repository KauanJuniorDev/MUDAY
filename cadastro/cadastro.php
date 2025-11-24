<?php
/*
    if(isset($_POST['submit'])) {

        //print_r($_POST['nome']);
        //print_r(<br>);
        //print_r($_POST['email']);
        //print_(<br>)
        //print_r($_POST['senha']);
        //print_r(<br>)
        //print_r($_POST['confSenha']);
        
        include_once('config.php');
        
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confSenha = $_POST['confSenha'];
        
        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha, confirmaSenha) VALUES ('$nome', '$email', '$senha', '$confSenha')");        
    }
*/

if(isset($_POST['submit'])) {
    include_once('config.php');

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confSenha = $_POST['confirmaSenha'];

    if ($senha !== $confSenha) {
        // tratar erro — senhas não conferem
        exit('Senhas não conferem.');
    }

    // validação básica do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Email inválido.');
    }

    // criar hash seguro
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // prepared statement
    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        header("Location: ../login/index.html");
        exit;
    } else {
        // tratar erro (ex: email duplicado)
        echo "Erro: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastre-se</title>
</head>
<body>

    <div class="navbar show-menu">
        <div class="header-inner-content">
 
            <h1 class="logo">MU<span>DAY</span></h1>

            <nav>
                <ul>
                    <li><a href="../login/index.html">Home</a></li>  
                </ul>
            </nav>

            <div class="nav-icon-container">
                <img src="img/menu.png" class="menu-button" alt="menu">
            </div>

        </div>

    </div>

    <div class="box">
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastre-se</b></legend>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo:</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email:</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha:</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="confirmaSenha" id="confirmaSenha" class="inputUser" required>
                    <label for="confirmaSenha" class="labelInput">Confirme a senha:</label>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit">

            </fieldset>
        </form>
    </div>
</body>
</html>
