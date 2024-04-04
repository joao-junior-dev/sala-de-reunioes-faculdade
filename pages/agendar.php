<?php
$db = new SQLite3('sistema_agendamento.db');

if (!$db) {
    die("Falha ao conectar ao banco de dados");
}

$query = "SELECT * FROM salas_reuniao";

$resultado = $db->query($query);

if ($resultado && $resultado->fetchArray(SQLITE3_ASSOC)) {
    $salas = [];
    $resultado->reset();

    while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
        $salas[] = $row;
    }
} else {
    $mensagem = "Não há salas disponíveis para agendamento.";
}

$db->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Reunião</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<h1>Agendar Reunião</h1>

<?php if (isset($salas) && !empty($salas)): ?>
    <form method="post" action="salvar_agendamento.php">
        <label for="sala">Selecione a Sala:</label><br>
        <select id="sala" name="sala">
            <?php foreach ($salas as $sala): ?>
                <option value="<?php echo $sala['id']; ?>"><?php echo $sala['nome']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="data">Data:</label><br>
        <input type="date" id="data" name="data"><br>
        <label for="horario">Horário:</label><br>
        <input type="time" id="horario_inicio" name="horario_inicio"><br>
        <input type="time" id="horario_fim" name="horario_fim"><br>
        <label for="organizador">Organizador:</label><br>
        <input type="text" id="organizador" name="organizador"><br>
        <label for="assunto">Assunto:</label><br>
        <input type="text" id="assunto" name="assunto"><br>
        <label for="participantes">Número de Participantes:</label><br>
        <input type="number" id="participantes" name="participantes"><br>
        <input type="submit" value="Agendar">
    </form>
<?php else: ?>
    <p><?php echo $mensagem; ?></p>
<?php endif; ?>

</body>
</html>
