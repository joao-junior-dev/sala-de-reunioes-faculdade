<?php
$db_file = 'sistema_agendamento.db';

try {
    $db = new SQLite3($db_file);

    $sql_create_salas_table = "CREATE TABLE IF NOT EXISTS salas_reuniao (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome VARCHAR(100) NOT NULL,
        capacidade INT NOT NULL,
        recursos TEXT,
        status TEXT
    )";
    $db->exec($sql_create_salas_table);

    $sql_create_agendamentos_table = "CREATE TABLE IF NOT EXISTS agendamentos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        sala_id INT NOT NULL,
        data DATE NOT NULL,
        horario_inicio TIME NOT NULL,
        horario_fim TIME NOT NULL,
        organizador VARCHAR(100) NOT NULL,
        assunto VARCHAR(255) NOT NULL,
        participantes INT NOT NULL,
        FOREIGN KEY (sala_id) REFERENCES salas_reuniao(id)
    )";
    $db->exec($sql_create_agendamentos_table);

    echo "Banco de dados e tabelas criadas com sucesso!";
} catch (Exception $e) {
    echo "Erro ao criar o banco de dados: " . $e->getMessage();
}
?>
