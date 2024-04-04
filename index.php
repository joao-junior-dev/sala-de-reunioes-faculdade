<?php
$db = new SQLite3('sistema_agendamento.db');

if (!$db) {
    die("Falha ao conectar ao banco de dados");
}

$query_salas = "SELECT * FROM salas_reuniao";

$resultado_salas = $db->query($query_salas);

if ($resultado_salas && $resultado_salas->fetchArray(SQLITE3_ASSOC)) {
    $salas = [];
    $resultado_salas->reset();

    while ($row = $resultado_salas->fetchArray(SQLITE3_ASSOC)) {
        $salas[] = $row;
    }
} else {
    $mensagem_salas = "Não há salas disponíveis.";
}

$query_reunioes = "SELECT * FROM agendamentos";

$resultado_reunioes = $db->query($query_reunioes);

if ($resultado_reunioes && $resultado_reunioes->fetchArray(SQLITE3_ASSOC)) {
    $reunioes = [];

    $resultado_reunioes->reset();

    while ($row = $resultado_reunioes->fetchArray(SQLITE3_ASSOC)) {
        $reunioes[] = $row;
    }
} else {
    $mensagem_reunioes = "Não há reuniões agendadas.";
}

$db->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento de Salas de Reuniões</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>

<h1>Sistema de Agendamento de Salas de Reuniões</h1>

<h2>Salas</h2>
<?php if (isset($salas) && !empty($salas)): ?>

    <ul>
        <?php foreach ($salas as $sala): ?>
            <li><?php echo $sala['nome']; ?> (Capacidade: <?php echo $sala['capacidade']; ?>) Status: <?php echo $sala['status']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p><?php echo $mensagem_salas; ?></p>
<?php endif; ?>

<h2>Reuniões Agendadas</h2>
<?php if (isset($reunioes) && !empty($reunioes)): ?>

    <ul>
        <?php foreach ($reunioes as $reuniao): ?>
            <li>Reunião agendada na sala <?php echo $sala['nome']; ?> em <?php echo $reuniao['data']; ?> às <?php echo $reuniao['horario_inicio']; ?> até <?php echo $reuniao['horario_fim']; ?>.</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p><?php echo $mensagem_reunioes; ?></p>
<?php endif; ?>

<button onclick="location.href='./pages/agendar.php'">Agendar Reunião</button>
<button onclick="location.href='./pages/gerenciar_salas.php'">Gerenciar Salas</button>
<button onclick="location.href='./pages/listar_agendamentos.php'" >Ver Agendamentos</button>

</body>
</html>
