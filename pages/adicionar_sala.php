<?php
$db = new SQLite3('sistema_agendamento.db');

if (!$db) {
    die("Falha ao conectar ao banco de dados");
}

$query_create_table = "CREATE TABLE IF NOT EXISTS salas_reuniao (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        nome TEXT NOT NULL,
                        capacidade INTEGER NOT NULL,
                        recursos TEXT,
                        status TEXT
                    )";

if (!$db->exec($query_create_table)) {
    die("Erro ao criar a tabela salas_reuniao");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $capacidade = $_POST["capacidade"];
    $recursos = $_POST["recursos"];
    $status = $_POST["status"];

    $stmt = $db->prepare("INSERT INTO salas_reuniao (nome, capacidade, recursos, status) VALUES (:nome, :capacidade, :recursos, :status)");

    if (!$stmt) {
        die("Erro na preparação da consulta SQL");
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':capacidade', $capacidade);
    $stmt->bindParam(':recursos', $recursos);
    $stmt->bindParam(':status', $status);

    $resultado = $stmt->execute();

    if (!$resultado) {
        die("Erro ao executar a consulta SQL");
    }

    $db->close();

    header("Location: gerenciar_salas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Sala</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<h1>Adicionar Sala</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome"><br>
    <label for="capacidade">Capacidade:</label><br>
    <input type="number" id="capacidade" name="capacidade"><br>
    <label for="recursos">Recursos:</label><br>
    <input type="text" id="recursos" name="recursos"><br>
    <label for="status">Status:</label><br>
    <select id="status" name="status">
        <option value="Disponível">Disponível</option>
        <option value="Indisponível">Indisponível</option>
    </select><br>
    <input type="submit" value="Enviar">
</form>

</body>
</html>
