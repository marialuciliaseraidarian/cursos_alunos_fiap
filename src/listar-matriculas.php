<h1 class="custom-text-color">Listagem de Matrículas</h1>

<style>
.pagination .page-item.active .page-link {
    background-color: #343a40;
    border-color: #343a40; 
    color: #ffffff; 
}
</style>

<!-- Formulário para selecionar o curso -->
<form method="GET" class="mb-4">
    <input type="hidden" name="page" value="listar-matriculas">
    <div class="form-group d-flex mt-4">
        <button type="submit" class="btn bg-dark custom-text-color">Filtrar</button>        
        <select name="curso_id" id="curso" class="form-control">
            <option value="">Todos os Cursos</option>

            <?php
            $sqlCursos = "SELECT id, nome FROM turmas ORDER BY nome ASC";
            $resultCursos = $conn->query($sqlCursos);
            while ($rowCurso = $resultCursos->fetch_assoc()) {
                $selected = isset($_GET['curso_id']) && $_GET['curso_id'] == $rowCurso['id'] ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($rowCurso['id']) . "' $selected>" . htmlspecialchars($rowCurso['nome']) . "</option>";
            }
            ?>
        </select>        
    </div>
    
</form>

<?php
require_once __DIR__ . '/../database/config.php';

$itensPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Verifica se um curso foi selecionado
$cursoId = isset($_GET['curso_id']) && $_GET['curso_id'] !== '' ? (int)$_GET['curso_id'] : null;

// Consulta SQL para buscar matrículas com paginação e filtro por curso, se aplicável
$sql = "SELECT matriculas.id, alunos.nome AS aluno_nome, turmas.nome AS turma_nome
        FROM matriculas
        JOIN alunos ON matriculas.aluno_id = alunos.id
        JOIN turmas ON matriculas.turma_id = turmas.id";

if ($cursoId) {
    $sql .= " WHERE turmas.id = $cursoId";
}

$sql .= " ORDER BY aluno_nome ASC
        LIMIT $itensPorPagina OFFSET $offset";

$result = $conn->query($sql);

// Consulta para contar o total de matrículas, com filtro por curso, se aplicável
$sqlTotal = "SELECT COUNT(*) AS total FROM matriculas
             JOIN turmas ON matriculas.turma_id = turmas.id";

if ($cursoId) {
    $sqlTotal .= " WHERE turmas.id = $cursoId";
}

$resultTotal = $conn->query($sqlTotal);
$totalMatriculas = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalMatriculas / $itensPorPagina);

if ($result->num_rows > 0) {
    print "<table class='table table-striped'>";
    print "<thead class='thead-dark'>";
    print "<tr>";
    print "<th>ID</th>";
    print "<th>Aluno</th>";
    print "<th>Turma</th>";
    print "<th>Ações</th>";
    print "</tr>";
    print "</thead>";
    print "<tbody>";
    while ($row = $result->fetch_assoc()) {
        print "<tr>";
        print "<td>" . htmlspecialchars($row["id"]) . "</td>";
        print "<td>" . htmlspecialchars($row["aluno_nome"]) . "</td>";
        print "<td>" . htmlspecialchars($row["turma_nome"]) . "</td>";
        print "<td>
               <button onclick=\"location.href='?page=cadastrar-matricula&id=" . $row["id"] . "';\" class='btn custom-text-color' title='Editar'><i class='fa fa-edit'></i></button>
               <button onclick=\"if(confirm('Tem certeza que deseja excluir este registro?')){location.href='?page=salvar-matricula&acao=excluir-matricula&id=" . $row["id"] . "';}else{}\" class='btn text-dark' title='Excluir'><i class='fa fa-trash'></i></button>
               </td>";
        print "</tr>";
    }

    echo '</tbody>';
    echo '</table>';

    // Paginação
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination d-flex justify-content-center">';

    if ($paginaAtual > 1) {
        echo '<li class="page-item"><a class="page-link custom-text-color" href="?page=listar-matriculas&pagina=' . ($paginaAtual - 1) . '&curso_id=' . $cursoId . '" aria-label="Previous">';
        echo '<span aria-hidden="true">&laquo;</span></a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link custom-text-color" aria-label="Previous">&laquo;</span></li>';
    }

    for ($i = 1; $i <= $totalPaginas; $i++) {
        echo '<li class="page-item' . ($i == $paginaAtual ? ' active ' : '') . '"><a class="page-link custom-text-color" href="?page=listar-matriculas&pagina=' . $i . '&curso_id=' . $cursoId . '">' . $i . '</a></li>';
    }

    if ($paginaAtual < $totalPaginas) {
        echo '<li class="page-item"><a class="page-link custom-text-color" href="?page=listar-matriculas&pagina=' . ($paginaAtual + 1) . '&curso_id=' . $cursoId . '" aria-label="Next">';
        echo '<span aria-hidden="true">&raquo;</span></a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link custom-text-color" aria-label="Next">&raquo;</span></li>';
    }

    echo '</ul>';
    echo '</nav>';
} else {
    echo '<div class="alert alert-warning" role="alert">Nenhuma matrícula encontrada.</div>';
}

$conn->close();

