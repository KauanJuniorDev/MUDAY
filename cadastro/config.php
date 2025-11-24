<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "muday";
    $port = "3307";

    $conexao = new mysqli($db_host, $db_user, $db_password, $db_name, $port);

    //if ($conexao->connect_error) {
    //    echo "Falha na conexaõ!";
    //}
    //else {
    //    echo "Conexão eftuada com sucesso!";
    //}
?>
