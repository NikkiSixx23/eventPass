<?php
include_once '../../backend/DataBase/conexaoDB.php';

if (!empty($_GET['id'])) {
    $idEvento = $_GET['id'];
    mysqli_query($conexao, 'DELETE FROM Eventos WHERE id = ' . $idEvento);
    $_SESSION['msg'] = 'Evento excluido com sucesso!!';
    header('Location: GerenciarEventos.php');
} else {
    echo '<p>EVENTO NÃO ENCONTRADO PARA REALIZAR EXCLUSÃO</p>';
    exit;
}
?>