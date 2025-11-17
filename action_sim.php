<?php
session_start();
include_once('cadastro/config.php');

if (empty($_SESSION['user_id'])) {
    header("Location: /login/index.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// busca dados do usuário
$stmt = $conexao->prepare("SELECT last_action, total_seconds FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($last_action, $total_seconds);
$stmt->fetch();
$stmt->close();

$agora = new DateTime();
$permitido = false;

if ($last_action) {
    $ultima = new DateTime($last_action);
    $diff = $agora->getTimestamp() - $ultima->getTimestamp();
    if ($diff >= 24 * 3600) {
        $permitido = true;
    } else {
        $restante = (24 * 3600) - $diff;
        echo "Faltam " . floor($restante / 3600) . "h " . floor(($restante % 3600) / 60) . "min para liberar novamente.";
        exit;
    }
} else {
    $permitido = true;
}

if ($permitido) {
    // Atualiza last_action e total_seconds (+24h = 86400s)
    $total_seconds += 24 * 3600;
    $stmt = $conexao->prepare("UPDATE usuarios SET last_action = NOW(), total_seconds = ? WHERE id = ?");
    $stmt->bind_param("ii", $total_seconds, $user_id);
    $stmt->execute();
    $stmt->close();
    echo "Contador iniciado! Você pode voltar em 24 horas.";
}
?>
