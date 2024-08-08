<?php

include __DIR__ . "/../database/config.php";

try {
    switch (@$_REQUEST["acao"]) {
        case 'salvar-turma':
            $nome = $_POST["nome"];
            $descricao = $_POST["descricao"];
            $tipo = $_POST["tipo"];

            // Verificar se o nome da turma tem mais de 3 caracteres
            if (strlen($nome) <= 3) {
                header("Location: index.php?page=cadastrar-turma&status=error&message=O nome da turma deve ter mais de 3 caracteres.");
                exit();
            }

            // Verificar se a turma já existe
            $checkSql = "SELECT id FROM turmas WHERE nome = ?";
            $checkStmt = $conn->prepare($checkSql);

            if ($checkStmt === false) {
                throw new Exception("Erro na preparação da consulta de verificação: " . $conn->error);
            }

            $checkStmt->bind_param("s", $nome);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                // Turma já está cadastrada
                header("Location: index.php?page=cadastrar-turma&status=error&message=Esta turma já está cadastrada no sistema.");
                $checkStmt->close();
                $conn->close();
                exit();
            }

            $checkStmt->close();

            // Inserir a nova turma
            $sql = "INSERT INTO turmas (nome, descricao, tipo) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("sss", $nome, $descricao, $tipo);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-turmas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao cadastrar turma: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'atualizar-turma':
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $tipo = $_POST['tipo'];

            // Atualizar dados da turma
            $sql = "UPDATE turmas SET nome = ?, descricao = ?, tipo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de atualização: " . $conn->error);
            }

            $stmt->bind_param("sssi", $nome, $descricao, $tipo, $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-turmas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao atualizar turma: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;

        case 'excluir-turma':
            $id = $_GET['id'];

            // Excluir turma
            $sql = "DELETE FROM turmas WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
            }

            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                header("Location: index.php?page=listar-turmas&success=true");
                exit();
            } else {
                throw new Exception("Erro ao excluir turma: " . $stmt->error);
            }

            $stmt->close();
            $conn->close();
            break;
    }
} catch (Exception $e) {
    header("Location: index.php?page=listar-turmas&status=error&message=" . urlencode($e->getMessage()));
    exit();
}
