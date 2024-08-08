<h1 class="custom-text-color">Cadastro de Aluno</h1>

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
                Aluno salvo com sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$nome = '';
$usuario = '';
$data_nascimento = '';

if ($id) {
    // Se o ID estiver presente, é uma edição
    $sql = "SELECT nome, usuario, data_nascimento FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = htmlspecialchars($row['nome']);
        $usuario = htmlspecialchars($row['usuario']);
        $data_nascimento = htmlspecialchars($row['data_nascimento']);
    } else {
        // Se o aluno não for encontrado, redireciona com mensagem de erro
        header("Location: index.php?page=listar-alunos&status=error&message=Aluno não encontrado.");
        exit();
    }
}
?>

<form action="?page=salvar-aluno" method="POST">
    <input type="hidden" name="acao" value="<?php echo $id ? 'atualizar-aluno' : 'salvar-aluno'; ?>">
    <?php if ($id) : ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-4 mt-4">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required minlength="3">
    </div>

    <div class="mb-4 mt-4">
        <label for="usuario" class="form-label">Usuário:</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>" required>
    </div> 

    <div class="mb-4 mt-4">
        <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo $data_nascimento; ?>" required>
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


