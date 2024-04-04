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
    $mensagem = "Não há salas disponíveis.";
}

$db->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Salas</title>
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>

<h1>Gerenciar Salas</h1>

<button onclick="location.href='adicionar_sala.php'">Adicionar Sala</button>

<?php if (isset($salas) && !empty($salas)): ?>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Capacidade</th>
                <th>Recursos</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
                <tr>
                    <td><?php echo $sala['nome']; ?></td>
                    <td><?php echo $sala['capacidade']; ?></td>
                    <td><?php echo $sala['recursos']; ?></td>
                    <td><?php echo $sala['status']; ?></td>
                    <td>
                        <button onclick="location.href='editar_sala.php?id=<?php echo $sala['id']; ?>'">Editar</button>
                        <button onclick="location.href='excluir_sala.php?id=<?php echo $sala['id']; ?>'">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p><?php echo $mensagem; ?></p>
<?php endif; ?>

</body>
</html>
