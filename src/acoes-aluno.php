<?php

include __DIR__ . "/../database/config.php";

try {
    switch (@$_REQUEST["acao"]) {
        case 'salvar-aluno':
            $nome = $_POST["nome"];
            $data_nascimento = $_POST["data_nascimento"];
            $usuario = $_POST["usuario"];

            // Verificar se o nome do aluno tem mais de 3 caracteres
            if (strlen($nome) <= 3) {
                header("Location: index.php?page=cadastrar-aluno&status=error&message=O nome do aluno deve ter mais de 3 caracteres.");
                exit();
            }

            // Verificar se o aluno já existe
            $checkSql = "SELECT id FROM alunos WHERE nome = ? AND usuario = ?";
            $checkStmt = $conn->prepare($checkSql);

            if ($checkStmt === false) {
                throw new Exception("Erro na preparação da consulta de verificação: " . $conn->error);
            }

            $checkStmt->bind_param("ss", $nome, $usuario);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                // Aluno já está cadastrado
                header("Location: index.php?page=cadastrar-aluno&status=error&message=Este aluno já está cadastrado no sistema.");
                $checkStmt->close();
                $conn->close();
                exit();
            }

            $checkStmt->close();

            // Inserir o novo aluno
            $sql = "INSERT INTO alunos (nome, data_nascimento, usuario) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("sss", $nome, $data_nascimento, $usuario);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-alunos&success=true");
                exit();
            } else {
                throw new Exception("Erro ao cadastrar aluno: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'atualizar-aluno':
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $data_nascimento = $_POST['data_nascimento'];
            $usuario = $_POST['usuario'];

            // Atualizar dados do aluno
            $sql = "UPDATE alunos SET nome = ?, data_nascimento = ?, usuario = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de atualização: " . $conn->error);
            }

            $stmt->bind_param("sssi", $nome, $data_nascimento, $usuario, $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-alunos&success=true");
                exit();
            } else {
                throw new Exception("Erro ao atualizar aluno: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'excluir-aluno':
            $id = $_GET['id'];

            // Excluir aluno
            $sql = "DELETE FROM alunos WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
            }

            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-alunos&success=true");
                exit();
            } else {
                throw new Exception("Erro ao excluir aluno: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;
    }
} catch (Exception $e) {
    header("Location: index.php?page=listar-alunos&status=error&message=" . urlencode($e->getMessage()));
    exit();
}
