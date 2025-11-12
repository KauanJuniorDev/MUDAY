<?php
session_start();
include_once('../cadastro/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT id, senha_hash FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    if ($stmt->fetch()) {
        if (password_verify($senha, $hash)) {
            $_SESSION['user_id'] = $id;
            header("Location: /index.php"); // ou home protegida
            exit;
        }
    }
    // erro de login
    header("Location: /login/index.html?error=1");
}
?>
