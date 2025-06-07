<?php
include_once "../../backend/DataBase/conexaoDB.php";

if (isset($_POST['editar']) && isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    if (empty($_FILES['capa'])) {
        mysqli_query($conexao, "UPDATE Eventos
    SET
        nome = " . $_POST['nome'] . ",
        data_evento = " . $_POST['data'] . " " . $_POST['horario'] . ",
        local_evento = " . $_POST['local'] . ",
        abertura = " . $_POST['abertura'] . ",
        preco_ingresso = " . $_POST['precoInteira'] . ",
        classificacao = " . $_POST['classificacao'] . ",
        capa = " . $_POST['logoAntiga'] . "
        WHERE id = " . $idEvento . ";");
    } else {
        mysqli_query($conexao, "UPDATE Eventos
        SET
            nome = " . $_POST['nome'] . ",
            data_evento = " . $_POST['data'] . " " . $_POST['horario'] . ",
            local_evento = " . $_POST['local'] . ",
            abertura = " . $_POST['abertura'] . ",
            preco_ingresso = " . $_POST['precoInteira'] . ",
            classificacao = " . $_POST['classificacao'] . ",
            capa = " . $_FILES['capa'] . "
            WHERE id = " . $idEvento . ";");
    }

    header("Location: GerenciarEventos.php");
} else if (isset($_POST['criar'])) {
    mysqli_query($conexao, "INSERT INTO Eventos (nome, data_evento, local_evento, abertura, preco_ingresso, classificacao, capa)
    VALUES
        (" . $_POST['nome'] . ",
        " . $_POST['data'] . " " . $_POST['horario'] . ",
        " . $_POST['local'] . ",
        " . $_POST['abertura'] . ",
        " . $_POST['precoInteira'] . ",
        " . $_POST['classificacao'] . ",
        " . $_POST['capa'] . ");");
}
