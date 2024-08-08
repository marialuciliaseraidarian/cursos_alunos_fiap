<h1 class="custom-text-color">Listagem de Turmas</h1>

<style>
.pagination .page-item.active .page-link {
    background-color: #343a40;
    border-color: #343a40; 
    color: #ffffff; 
}
</style>

<?php
require_once __DIR__ . '/../database/config.php';

$itensPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $itensPorPagina;

// Consulta SQL para buscar turmas com paginação
$sql = "SELECT * FROM turmas ORDER BY nome ASC LIMIT $itensPorPagina OFFSET $offset";
$result = $conn->query($sql);

// Consulta para contar o total de turmas
$sqlTotal = "SELECT COUNT(*) AS total FROM turmas";
$resultTotal = $conn->query($sqlTotal);
$totalTurmas = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalTurmas / $itensPorPagina);

if ($result->num_rows > 0) {
    print "<table class='table table-striped'>";
    print "<thead class='thead-dark'>";
    print "<tr>";
    print "<th>ID</th>";
    print "<th>Nome</th>";
    print "<th>Descrição</th>";
    print "<th>Tipo</th>";
    print "<th>Ações</th>";
    print "</tr>";
    print "</thead>";
    print "<tbody>";
    while ($row = $result->fetch_assoc()) {
        print "<tr>";
        print "<td>" . htmlspecialchars($row["id"]) . "</td>";
        print "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        print "<td>" . htmlspecialchars($row["descricao"]) . "</td>";
        print "<td>" . htmlspecialchars($row["tipo"]) . "</td>";
        print "<td>
               <button onclick=\"location.href='?page=cadastrar-turma&id=" . $row["id"] . "';\" class='btn custom-text-color' title='Editar'><i class='fa fa-edit'></i></button>
               <button onclick=\"if(confirm('Tem certeza que deseja excluir esta turma?')){location.href='?page=salvar-turma&acao=excluir-turma&id=" . $row["id"] . "';}else{}\" class='btn text-dark' title='Excluir'><i class='fa fa-trash'></i></button>
               </td>";
        print "</tr>";
    }

    echo '</tbody>';
    echo '</table>';

    // Paginação
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination d-flex justify-content-center">';

    if ($paginaAtual > 1) {
        echo '<li class="page-item"><a class="page-link custom-text-color" href="?page=listar-turmas&pagina=' . ($paginaAtual - 1) . '" aria-label="Previous">';
        echo '<span aria-hidden="true">&laquo;</span></a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link custom-text-color" aria-label="Previous">&laquo;</span></li>';
    }

    for ($i = 1; $i <= $totalPaginas; $i++) {
        echo '<li class="page-item' . ($i == $paginaAtual ? ' active ' : '') . '"><a class="page-link custom-text-color" href="?page=listar-turmas&pagina=' . $i . '">' . $i . '</a></li>';
    }

    if ($paginaAtual < $totalPaginas) {
        echo '<li class="page-item"><a class="page-link custom-text-color" href="?page=listar-turmas&pagina=' . ($paginaAtual + 1) . '" aria-label="Next">';
        echo '<span aria-hidden="true">&raquo;</span></a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link custom-text-color" aria-label="Next">&raquo;</span></li>';
    }

    echo '</ul>';
    echo '</nav>';
} else {
    echo '<div class="alert alert-warning" role="alert">Nenhuma turma encontrada.</div>';
}

$conn->close();
?>
