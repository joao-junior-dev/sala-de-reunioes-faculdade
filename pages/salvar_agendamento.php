<?php
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os dados do formulário
    $sala_id = $_POST['sala'];
    $data = $_POST['data'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fim = $_POST['horario_fim'];
    $nome_organizador = $_POST['organizador'];
    $assunto = $_POST['assunto'];

    // Conectar ao banco de dados SQLite
    $db = new SQLite3('sistema_agendamento.db');

    // Verificar a conexão com o banco de dados
    if (!$db) {
        die("Erro ao conectar ao banco de dados");
    }

    // Verificar se a sala está disponível no intervalo de horários escolhido
    $query = "SELECT * FROM agendamentos 
              WHERE sala_id = :sala_id 
              AND data = :data 
              AND ((:horario_inicio BETWEEN horario_inicio AND horario_fim) 
                   OR (:horario_fim BETWEEN horario_inicio AND horario_fim)
                   OR (horario_inicio BETWEEN :horario_inicio AND :horario_fim)
                   OR (horario_fim BETWEEN :horario_inicio AND :horario_fim))";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':sala_id', $sala_id);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':horario_inicio', $horario_inicio);
    $stmt->bindParam(':horario_fim', $horario_fim);
    
    $result = $stmt->execute();

    if ($result->fetchArray() !== false) {
        // Sala está ocupada neste intervalo de horários
        echo "Esta sala já está agendada para este horário. Por favor, escolha outro horário.";
    } else {
        // Inserir o agendamento no banco de dados
        $insertQuery = "INSERT INTO agendamentos (sala_id, data, horario_inicio, horario_fim, organizador, assunto)
                        VALUES (:sala_id, :data, :horario_inicio, :horario_fim, :organizador, :assunto)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindParam(':sala_id', $sala_id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':horario_inicio', $horario_inicio);
        $stmt->bindParam(':horario_fim', $horario_fim);
        $stmt->bindParam(':nome_organizador', $nome_organizador);
        $stmt->bindParam(':assunto', $assunto);

        if ($stmt->execute()) {
            echo "Reunião agendada com sucesso!";
        } else {
            echo "Erro ao agendar a reunião";
        }
    }

    // Fechar conexão com o banco de dados
    $db->close();
} else {
    echo "Acesso inválido ao script";
}
?>
