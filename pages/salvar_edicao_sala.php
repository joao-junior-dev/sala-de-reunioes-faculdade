<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salvar Edição da Sala</title>
</head>
<body>

<div class="container">
    <?php
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se o ID da sala foi recebido
        if (isset($_POST['sala_id'])) {
            $sala_id = $_POST['sala_id'];

            // Conexão com o banco de dados SQLite
            $db = new SQLite3('sistema_agendamento.db');

            // Verificação da conexão
            if (!$db) {
                die("Falha ao conectar ao banco de dados");
            }

            // Prepara a consulta SQL para atualizar os dados da sala
            $query_atualizar_sala = "UPDATE salas_reuniao SET 
                                    nome = :nome, 
                                    capacidade = :capacidade, 
                                    recursos = :recursos, 
                                    status = :status 
                                    WHERE id = :sala_id";

            // Prepara a declaração SQL
            $stmt = $db->prepare($query_atualizar_sala);

            // Associa os parâmetros da declaração SQL aos valores do formulário
            $stmt->bindParam(':nome', $_POST['nome'], SQLITE3_TEXT);
            $stmt->bindParam(':capacidade', $_POST['capacidade'], SQLITE3_INTEGER);
            $stmt->bindParam(':recursos', $_POST['recursos'], SQLITE3_TEXT);
            $stmt->bindParam(':status', $_POST['status'], SQLITE3_TEXT);
            $stmt->bindParam(':sala_id', $sala_id, SQLITE3_INTEGER);

            // Executa a declaração SQL
            $resultado = $stmt->execute();

            // Verifica se a atualização foi bem-sucedida
            if ($resultado) {
                echo "Alterações na sala foram salvas com sucesso.";
            } else {
                echo "Erro ao salvar alterações na sala.";
            }

            // Fecha a conexão com o banco de dados
            $db->close();

            // Botão "Voltar para Editar Sala"
            echo '<br><button onclick="window.location.href=\'../index.php?id=' . $sala_id . '\'">Voltar para página inicial</button>';
        } else {
            echo "ID da sala não especificado.";
        }
    } else {
        // Se o formulário não foi submetido via método POST
        echo "Método inválido para processar os dados.";
    }
    ?>
</div>

</body>
</html>
