<?php
include 'config.php'; // Inclui a configuração do banco de dados

// Buscar alunos para exibição
$sql = "SELECT * FROM aluno";
$result = $conn->query($sql);
$conn->close();

// Mensagens
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function editAluno(matricula, nome, idade, turma, telefone) {
            document.getElementById('editMatricula').value = matricula;
            document.getElementById('nome').value = nome;
            document.getElementById('idade').value = idade;
            document.getElementById('turma').value = turma;
            document.getElementById('telefone').value = telefone;
            document.querySelector('input[name="action"]').value = 'update';
            document.getElementById('updateButton').style.display = 'inline';
            document.getElementById('deleteButton').style.display = 'inline';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Aluno</h1>
        <form method="post" action="process.php">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="matricula" id="editMatricula">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            
            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required><br><br>
            
            <label for="turma">Turma:</label>
            <input type="text" id="turma" name="turma" required><br><br>
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required><br><br>
            
            <input type="submit" value="Cadastrar">
            <input type="submit" value="Atualizar" id="updateButton" style="display:none;">
            <input type="submit" value="Excluir" id="deleteButton" style="display:none;">
        </form>
        <?php if ($msg): ?>
            <p style="color: green;"><?php echo $msg; ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <h2>Lista de Alunos</h2>
        <table>
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Turma</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['matricula']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['idade']; ?></td>
                        <td><?php echo $row['turma']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td>
                            <button onclick="editAluno(<?php echo $row['matricula']; ?>, '<?php echo $row['nome']; ?>', <?php echo $row['idade']; ?>, '<?php echo $row['turma']; ?>', '<?php echo $row['telefone']; ?>')">Editar</button>
                            <form method="post" action="process.php" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="matricula" value="<?php echo $row['matricula']; ?>">
                                <input type="submit" value="Excluir">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
