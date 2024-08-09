<h1 class="custom-text-color">Cadastro de Matrícula</h1>

<?php if (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
    <div class="toast align-items-center custom-text-color bg-dark border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php elseif (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
    <div class="toast align-items-center custom-text-color bg-dark border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Matrícula salva com sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$aluno_id = '';
$turma_id = '';

if ($id) {
    // Se o ID estiver presente, é uma edição
    $sql = "SELECT aluno_id, turma_id FROM matriculas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $aluno_id = htmlspecialchars($row['aluno_id']);
        $turma_id = htmlspecialchars($row['turma_id']);
    } else {
        // Se a matrícula não for encontrada, redireciona com mensagem de erro
        header("Location: index.php?page=listar-matriculas&status=error&message=Matrícula não encontrada.");
        exit();
    }
}
?>

<form action="?page=salvar-matricula" method="POST">
    <input type="hidden" name="acao" value="<?php echo $id ? 'atualizar-matricula' : 'salvar-matricula'; ?>">
    <?php if ($id) : ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>

    <div class="mb-4 mt-4">
        <label for="aluno_id" class="form-label">Aluno:</label>
        <select id="aluno_id" name="aluno_id" class="form-control" required>
            <option value="">Selecione um aluno</option>
            <?php
            $result = $conn->query("SELECT id, nome FROM alunos ORDER BY nome ASC");
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $aluno_id) ? 'selected' : '';
                echo "<option value='{$row['id']}' {$selected}>{$row['nome']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-4 mt-4">
        <label for="turma_id" class="form-label">Turma:</label>
        <select id="turma_id" name="turma_id" class="form-control" required>
            <option value="">Selecione uma turma</option>
            <?php
            $result = $conn->query("SELECT id, nome FROM turmas ORDER BY nome ASC");
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $turma_id) ? 'selected' : '';
                echo "<option value='{$row['id']}' {$selected}>{$row['nome']}</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn bg-dark custom-text-color"><?php echo $id ? 'Atualizar' : 'Salvar'; ?></button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {    
    const params = new URLSearchParams(window.location.search);
    if (params.get('success') === 'true' || params.get('status') === 'error') {
        var toastElement = document.querySelector('.toast');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
});
</script>
