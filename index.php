<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cursos e Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
      .custom-text-color {
        color: #ED1A5D !important;
      }      
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand custom-text-color" href="#">FIAP - Cursos e Alunos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-around" id="navbarNavDropdown">
          <ul class="navbar-nav">         
            <li class="nav-item dropdown">        
              <a class="nav-link dropdown-toggle custom-text-color" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-user"></i> Alunos
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=listar-alunos">Listar Alunos</a></li>
                <li><a class="dropdown-item" href="?page=cadastrar-aluno">Cadastrar Aluno</a></li>            
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle custom-text-color" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-users"></i> Turmas          
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=listar-turmas">Listar Turmas</a></li>
                <li><a class="dropdown-item" href="?page=cadastrar-turma">Cadastrar Turma</a></li>            
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle custom-text-color" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-regular fa-file-lines"></i> Matrículas
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=listar-matriculas">Listar Matrículas</a></li>
                <li><a class="dropdown-item" href="?page=cadastrar-matricula">Cadastrar Matrícula</a></li>            
              </ul>
            </li>       
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col mt-5">
            <?php
            require_once __DIR__ . "/database/Database.php";
            use Database\Database;
            $conn = Database::getConnection();
            switch (@$_REQUEST["page"]) {
                case "cadastrar-aluno":
                    include __DIR__ . "/src/cadastrar-aluno.php";
                    break;
                case "listar-alunos":
                    include __DIR__ . "/src/listar-alunos.php";
                    break;
                case "listar-turmas":
                    include __DIR__ . "/src/listar-turmas.php";
                    break;
                case "cadastrar-turma":
                    include __DIR__ . "/src/cadastrar-turma.php";
                    break;
                case "listar-matriculas":
                    include __DIR__ . "/src/listar-matriculas.php";
                    break;
                case "cadastrar-matricula":
                    include __DIR__ . "/src/cadastrar-matricula.php";
                    break;
                case "salvar-aluno":
                    include __DIR__ . "/src/acoes-aluno.php";
                    break;
                case "salvar-turma":
                    include __DIR__ . "/src/acoes-turma.php";
                    break;
                case "salvar-matricula":
                    include __DIR__ . "/src/acoes-matricula.php";
                    break;
                default:
                    print "
                  <h1 class='text-center custom-text-color'>Bem-vindos!</h1>
                  <h2 class='text-center'>Ao sistema de gerenciamento de cursos e alunos Fiap</h2>
                  <div class='text-center mt-4'>
                      <img src='public/images/Fiap-logo-novo.jpg' alt='Logo Fiap' class='img-fluid m-4'>
                  </div>                    
                  ";
            }
            ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
