<?php
// Conexão com o banco de dados SQLite
$db = new SQLite3('sistema_agendamento.db');

// Verificação da conexão
if (!$db) {
    die("Falha ao conectar ao banco de dados");
}

// Verificação se o parâmetro 'id' da sala foi passado na URL
if (isset($_GET['id'])) {
    $sala_id = $_GET['id'];

    // Consulta SQL para obter os dados da sala com base no ID
    $query_obter_sala = "SELECT * FROM salas_reuniao WHERE id = :sala_id";
    $stmt = $db->prepare($query_obter_sala);
    $stmt->bindParam(':sala_id', $sala_id, SQLITE3_INTEGER);
    $resultado = $stmt->execute();

    // Verificação se a consulta retornou resultados
    if ($resultado) {
        $sala = $resultado->fetchArray(SQLITE3_ASSOC);
        if (!$sala) {
            die("Sala não encontrada");
        }
    } else {
        die("Erro ao obter dados da sala");
    }
} else {
    die("ID da sala não especificado");
}

// Fechar a conexão com o banco de dados
$db->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sala</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Importar o arquivo de estilo CSS -->
</head>
<body>

<div class="container">
    <h1>Editar Sala</h1>

    <form method="post" action="salvar_edicao_sala.php">
        <input type="hidden" name="sala_id" value="<?php echo $sala['id']; ?>">

        <div class="form-group">
            <label for="nome">Nome da Sala:</label>
            <input type="text" name="nome" id="nome" value="<?php echo $sala['nome']; ?>" required>
        </div>
        <div class="form-group">
            <label for="capacidade">Capacidade:</label>
            <input type="number" name="capacidade" id="capacidade" value="<?php echo $sala['capacidade']; ?>" required>
        </div>
        <div class="form-group">
            <label for="recursos">Recursos Disponíveis:</label>
            <textarea name="recursos" id="recursos"><?php echo $sala['recursos']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="ocupada" <?php echo ($sala['status'] == 'ocupada') ? 'selected' : ''; ?>>Ocupada</option>
                <option value="disponivel" <?php echo ($sala['status'] == 'disponivel') ? 'selected' : ''; ?>>Disponível</option>
            </select>
        </div>
        
        <button type="submit">Salvar Alterações</button>
    </form
