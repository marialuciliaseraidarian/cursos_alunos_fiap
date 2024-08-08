<h1 class="custom-text-color">Cadastro de Turma</h1>

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
                Turma salva com sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$nome = '';
$descricao = '';
$tipo = '';

if ($id) {
    $sql = "SELECT nome, descricao, tipo FROM turmas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = htmlspecialchars($row['nome']);
        $descricao = htmlspecialchars($row['descricao']);
        $tipo = htmlspecialchars($row['tipo']);
    } else {
        // Se a turma não for encontrada, redireciona com mensagem de erro
        header("Location: index.php?page=listar-turmas&status=error&message=Turma não encontrada.");
        exit();
    }
}
?>

<form action="?page=salvar-turma" method="POST">
    <input type="hidden" name="acao" value="<?php echo $id ? 'atualizar-turma' : 'salvar-turma'; ?>">
    <?php if ($id) : ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-4 mt-4">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required minlength="3">
    </div>

    <div class="mb-4 mt-4">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao"><?php echo $descricao; ?></textarea>
    </div> 

    <div class="mb-4 mt-4">
        <label for="tipo" class="form-label">Tipo:</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo; ?>" required>
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
