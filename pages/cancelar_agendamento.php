<?php
// Verificar se o ID do agendamento foi fornecido na URL
if (isset($_GET['id'])) {
    $agendamento_id = $_GET['id'];

    // Conexão com o banco de dados SQLite
    $database = new SQLite3('sistema_agendamento.db');

    // Verificar a conexão
    if (!$database) {
        die("Erro ao conectar ao banco de dados.");
    }

    // Preparar e executar a consulta para excluir o agendamento
    $query = "DELETE FROM agendamentos WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindParam(':id', $agendamento_id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "Agendamento cancelado com sucesso.";
    } else {
        echo "Erro ao cancelar o agendamento.";
    }

    // Fechar conexão com o banco de dados
    $database->close();
} else {
    echo "ID do agendamento não fornecido.";
}
?>
