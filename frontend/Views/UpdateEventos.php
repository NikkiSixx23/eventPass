<?php
include_once "../../backend/DataBase/conexaoDB.php";

if (isset($_POST['editar']) && isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    if (!isset($_FILES['capa']) || $_FILES['capa']['error'] === 4) {

        $consulta = mysqli_query($conexao, "UPDATE Eventos
        SET
            nome = '" . $_POST['nomeEvento'] . "',
            data_evento = '" . $_POST['data'] . " " . $_POST['horario'] . "',
            local_evento = '" . $_POST['local'] . "',
            abertura = '" . $_POST['abertura'] . "',
            preco_ingresso = " . $_POST['precoInteira'] . ",
            classificacao = '" . $_POST['classificacao'] . "',
            logo = '" . mysqli_real_escape_string($conexao, base64_decode($_POST['logoAntiga'])) . "'
            WHERE id = " . $idEvento . ";");

        header("Location: GerenciarEventos.php");
    } else {

        $logoNova = mysqli_real_escape_string($conexao, file_get_contents($_FILES['capa']['tmp_name']));

        $consulta = mysqli_query($conexao, "UPDATE Eventos
        SET
            nome = '" . $_POST['nomeEvento'] . "',
            data_evento = '" . $_POST['data'] . " " . $_POST['horario'] . "',
            local_evento = '" . $_POST['local'] . "',
            abertura = '" . $_POST['abertura'] . "',
            preco_ingresso = " . $_POST['precoInteira'] . ",
            classificacao = '" . $_POST['classificacao'] . "',
            logo = '" . $logoNova . "'
            WHERE id = " . $idEvento . ";");

        header("Location: GerenciarEventos.php");
    }
} else if (isset($_POST['criar'])) {

    $logoNova = mysqli_real_escape_string($conexao, file_get_contents($_FILES['capa']['tmp_name']));

    mysqli_query($conexao, "INSERT INTO Eventos (nome, data_evento, local_evento, abertura, preco_ingresso, classificacao, capa)
    VALUES
        ('" . $_POST['nome'] . "',
        '" . $_POST['data'] . " " . $_POST['horario'] . "',
        '" . $_POST['local'] . "',
        '" . $_POST['abertura'] . "',
        " . $_POST['precoInteira'] . ",
        '" . $_POST['classificacao'] . "',
        '" . $logoNova . "');");

    header("Location: GerenciarEventos.php");
} else if (isset($_POST['excluir']) && isset($_GET['id'])) {

    $idEvento = $_GET['id'];

    mysqli_query($conexao, 'DELETE FROM Eventos WHERE id = ' . $idEvento. ';');
    $_SESSION['msg'] = 'Evento excluido com sucesso!!';
    header('Location: GerenciarEventos.php');
}
