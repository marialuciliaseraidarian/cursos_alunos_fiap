<?php

include __DIR__ . "/../database/config.php";

try {
    switch (@$_REQUEST["acao"]) {
        case 'salvar-matricula':
            $aluno_id = $_POST["aluno_id"];
            $turma_id = $_POST["turma_id"];

            // Verificar se a matrícula já existe
            $checkSql = "SELECT id FROM matriculas WHERE aluno_id = ? AND turma_id = ?";
            $checkStmt = $conn->prepare($checkSql);

            if ($checkStmt === false) {
                throw new Exception("Erro na preparação da consulta de verificação: " . $conn->error);
            }

            $checkStmt->bind_param("ii", $aluno_id, $turma_id);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                // Matrícula já existe
                header("Location: index.php?page=cadastrar-matricula&status=error&message=Este aluno já está matriculado nesta turma.");
                $checkStmt->close();
                $conn->close();
                exit();
            }

            $checkStmt->close();

            // Inserir nova matrícula
            $sql = "INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("ii", $aluno_id, $turma_id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-matriculas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao cadastrar matrícula: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'atualizar-matricula':
            $id = $_POST['id'];
            $aluno_id = $_POST['aluno_id'];
            $turma_id = $_POST['turma_id'];

            // Atualizar matrícula
            $sql = "UPDATE matriculas SET aluno_id = ?, turma_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de atualização: " . $conn->error);
            }

            $stmt->bind_param("iii", $aluno_id, $turma_id, $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-matriculas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao atualizar matrícula: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'excluir-matricula':
            $id = $_GET['id'];

            // Excluir matrícula
            $sql = "DELETE FROM matriculas WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
            }

            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-matriculas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao excluir matrícula: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;
    }
} catch (Exception $e) {
    header("Location: index.php?page=listar-matriculas&status=error&message=" . urlencode($e->getMessage()));
    exit();
}
