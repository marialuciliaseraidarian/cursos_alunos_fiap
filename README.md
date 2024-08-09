# Curso de Alunos FIAP

Este projeto é uma aplicação para gerenciar alunos e matrículas em turmas.

## Estrutura do Projeto

O projeto é organizado da seguinte maneira:

- **cursos_alunos_fiap/**: Pasta principal do projeto.
  - **database/**: Contém arquivos relacionados ao banco de dados.
    - `config.php`: Arquivo de configuração do banco de dados. :file_folder:
    - `Database.php`: Arquivo para a conexão com o banco de dados. :file_folder:
    - `dump.sql`: Script SQL para criação das tabelas e inserção de dados. :file_folder:
  - **public/**: Contém arquivos públicos.    
    - `imagens/`: Pasta com imagens. :file_folder:
  - **src/**: Contém todos os arquivos do código-fonte.
    - `actions-matricula.php`: Arquivo para ações relacionadas a matrículas. :file_code:
    - `cadastrar-aluno.php`: Formulário para cadastro e edição de alunos. :file_code:
    - `listar-alunos.php`: Listagem de alunos com paginação. :file_code:
    - `cadastrar-matricula.php`: Formulário para cadastro e edição de matrículas. :file_code:
    - `listar-matriculas.php`: Listagem de matrículas com paginação. :file_code:

## Instalação

Para configurar e rodar a aplicação, siga os seguintes passos:

1. **Clone o repositório:**

   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd cursos_alunos_fiap
Configure o banco de dados:

Acesse o MySQL ou MariaDB e crie um banco de dados para o projeto.

Importe o arquivo dump.sql para criar as tabelas e inserir alguns dados:

bash
Copiar código
mysql -u <USUARIO> -p <NOME_DO_BANCO> < database/dump.sql
Edite o arquivo database/config.php para configurar as credenciais de acesso ao banco de dados:

php
Copiar código
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'senha');
define('DB_DATABASE', 'nome_do_banco');
?>
Configuração do servidor web:

Certifique-se de que o servidor web está configurado para usar o PHP e que o diretório public/ está configurado como a raiz do documento.

Acesse a aplicação:

Abra um navegador e acesse o URL onde a aplicação está hospedada (por exemplo, http://localhost).

Como Usar
Cadastro de Alunos: Acesse a página de cadastro de alunos para adicionar novos alunos ou editar os existentes. :pencil:
Listagem de Alunos: Veja a lista de alunos cadastrados e realize operações como editar ou excluir. :clipboard:
Cadastro de Matrículas: Adicione novas matrículas para alunos e turmas. :pencil:
Listagem de Matrículas: Visualize a lista de matrículas existentes e realize operações como editar ou excluir. :clipboard: