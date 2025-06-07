<?php
include_once '../../backend/DataBase/conexaoDB.php';

if (!isset($_GET['id'])) {
    echo json_encode(["erro" => "ID do evento não informado."]);
    exit;
}

$idEvento = $_GET['id'];

$consulta = mysqli_query($conexao, "SELECT * FROM Eventos WHERE id = $idEvento");

if ($consulta) {
    header('Content-Type: application/json');
    echo json_encode($consulta);
} else {
    echo json_encode(["erro" => "Evento não encontrado."]);
}
?>