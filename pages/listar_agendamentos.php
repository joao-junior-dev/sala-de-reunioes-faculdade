<?php
// Conexão com o banco de dados SQLite (substitua pelo caminho do seu banco)
$database = new SQLite3('sistema_agendamento.db');

// Verificar a conexão
if (!$database) {
    die("Erro ao conectar ao banco de dados.");
}

// Consulta para recuperar os agendamentos
$query = "SELECT * FROM agendamentos";
$result = $database->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Agendamentos</title>
    <!-- Adicionar link para seu arquivo CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Lista de Agendamentos</h1>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Horário_inicio</th>
                <th>Horário_fim</th>
                <th>Organizador</th>
                <th>Assunto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibir os agendamentos em uma tabela
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['data']}</td>";
                echo "<td>{$row['horario_inicio']}</td>";
                echo "<td>{$row['horario_fim']}</td>";
                echo "<td>{$row['organizador']}</td>";
                echo "<td>{$row['assunto']}</td>";
                echo "<td><a href='cancelar_agendamento.php?id={$row['id']}'>Cancelar</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Fechar conexão com o banco de dados
$database->close();
?>
