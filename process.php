<?php
include 'config.php'; // Inclui a configuração do banco de dados

// Variáveis para mensagens
$msg = "";
$error = "";

// Adicionar ou atualizar aluno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $matricula = $_POST['matricula'];
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $turma = $_POST['turma'];
        $telefone = $_POST['telefone'];

        $sql = "UPDATE aluno SET nome=?, idade=?, turma=?, telefone=? WHERE matricula=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $nome, $idade, $turma, $telefone, $matricula);

        if ($stmt->execute()) {
            $msg = "Aluno atualizado com sucesso!";
        } else {
            $error = "Erro ao atualizar aluno: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $matricula = $_POST['matricula'];

        $sql = "DELETE FROM aluno WHERE matricula=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $matricula);

        if ($stmt->execute()) {
            $msg = "Aluno excluído com sucesso!";
        } else {
            $error = "Erro ao excluir aluno: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $turma = $_POST['turma'];
        $telefone = $_POST['telefone'];

        if (!empty($nome) && !empty($idade) && !empty($turma) && !empty($telefone)) {
            $sql = "INSERT INTO aluno (nome, idade, turma, telefone) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $nome, $idade, $turma, $telefone);

            if ($stmt->execute()) {
                $msg = "Aluno cadastrado com sucesso!";
            } else {
                $error = "Erro ao cadastrar aluno: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Todos os campos são obrigatórios.";
        }
    }
}

// Buscar alunos para exibição
$sql = "SELECT * FROM aluno";
$result = $conn->query($sql);

$conn->close();

// Redirecionar de volta para o formulário
header("Location: index.php?msg=$msg&error=$error");
exit();
?>
