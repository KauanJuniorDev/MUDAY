<?php
session_start();
include_once('cadastro/config.php');
header('Content-Type: application/json');

if (empty($_SESSION['user_id'])) {
    echo json_encode(["error" => "not_logged"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conexao->prepare("SELECT total_seconds FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_seconds);
$stmt->fetch();
$stmt->close();

$dias = floor($total_seconds / 86400);
$resto = $total_seconds % 86400;

$horas = floor($resto / 3600);
$resto = $resto % 3600;

$minutos = floor($resto / 60);
$segundos = $resto % 60;

echo json_encode([
    "dias" => $dias,
    "horas" => $horas,
    "minutos" => $minutos,
    "segundos" => $segundos
]);
