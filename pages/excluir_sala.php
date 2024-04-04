<?php
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];

    $db = new SQLite3('sistema_agendamento.db');

    if (!$db) {
        die("Falha ao conectar ao banco de dados");
    }

    $stmt = $db->prepare("DELETE FROM salas_reuniao WHERE id = :id");

    if (!$stmt) {
        die("Erro na preparação da consulta SQL");
    }

    $stmt->bindParam(':id', $id);

    $resultado = $stmt->execute();

    if (!$resultado) {
        die("Erro ao excluir a sala");
    }

    $db->close();

    header("Location: gerenciar_salas.php");
    exit();
} else {
    header("Location: gerenciar_salas.php");
    exit();
}
?>
