<?php
session_start();
include_once('../cadastro/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $nome, $hash);
    if ($stmt->fetch()) {
        if (password_verify($senha, $hash)) {
            $_SESSION['user_id'] = $id;
            header("Location: ../index.php");
            exit;
        }
    }
    // erro de login
    header("Location: /MUDAY/login/index.html?error=1");
}
?>
