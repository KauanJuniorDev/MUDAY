<?php
session_start();
include_once('../cadastro/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

<<<<<<< HEAD
    $stmt = $conexao->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
=======
    $stmt = $conexao->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE email = ?");
>>>>>>> ba43d36a8fc1523746cee11636849478f7fc4b3e
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $nome, $hash);
    if ($stmt->fetch()) {
        if (password_verify($senha, $hash)) {
            $_SESSION['user_id'] = $id;
<<<<<<< HEAD
            header("Location: /index.php");
=======
            $_SESSION['nome'] = $nome;
            //echo $id;
           	header("Location: /MUDAY/index.php");
>>>>>>> ba43d36a8fc1523746cee11636849478f7fc4b3e
            exit;
        }
    }
    // erro de login
    header("Location: /MUDAY/login/index.html?error=1");
}
?>
