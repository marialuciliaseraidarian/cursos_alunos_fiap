# Curso e Alunos FIAP

Este projeto é uma aplicação para gerenciar cursos e alunos, desenvolvida como parte de um desafio para a FIAP.

## Arquitetura do Projeto

Este projeto segue um padrão procedural, utilizando PHP e SQL. A escolha por um estilo procedural foi feita para simplificar a implementação e focar na resolução das necessidades específicas do desafio proposto.

Essa abordagem permite uma organização clara das operações, facilitando a manutenção e a leitura do código para projetos de menor escala como este.

## Estrutura do Projeto

O projeto está organizado da seguinte forma:

- **cursos_alunos_fiap/**: Diretório raiz do projeto.
  - **database/**: Arquivos relacionados ao banco de dados.
    - `config.php`: Arquivo de configuração do banco de dados.
    - `Database.php`: Script de conexão com o banco de dados.
    - `dump.sql`: Script SQL para criação das tabelas e inserção de dados iniciais.
  - **public/**: Arquivos públicos.
    - `imagens/`: Diretório para armazenamento de imagens.
  - **src/**: Código-fonte da aplicação.
    - `actions-matricula.php`: Ações relacionadas a matrículas.
    - `cadastrar-aluno.php`: Formulário para cadastro e edição de alunos.
    - `listar-alunos.php`: Listagem de alunos com paginação.
    - `cadastrar-matricula.php`: Formulário para cadastro e edição de matrículas.
    - `listar-matriculas.php`: Listagem de matrículas com paginação.

## Instalação

Para configurar e rodar a aplicação, siga os seguintes passos:

1. **Clone o repositório:**

   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd cursos_alunos_fiap

   ```

2. **Configure o banco de dados:**

Acesse o MySQL e crie um banco de dados para o projeto.

Importe o arquivo dump.sql para criar as tabelas e inserir alguns dados:

```bash
mysql -u <USUARIO> -p <NOME_DO_BANCO> < database/dump.sql

```

Edite o arquivo database/config.php para configurar as credenciais de acesso ao banco de dados:

```php
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'senha');
define('DB_DATABASE', 'nome_do_banco');
?>

```

3. **Configuração do servidor web:**

Certifique-se de que o servidor web está configurado para usar o PHP e que o diretório public/ está configurado como a raiz do documento.

4. **Acesse a aplicação:**

Abra um navegador e acesse o URL onde a aplicação está hospedada (por exemplo, http://localhost).

## Como Usar

- **Cadastro de Alunos**: Acesse a página de cadastro de alunos para adicionar novos alunos. :pencil:
- **Listagem de Alunos**: Veja a lista de alunos cadastrados e realize operações como editar ou excluir. :clipboard:
- **Cadastro de Turmas**: Acesse a página de cadastro de turmas para adicionar novas turmas. :pencil:
- **Listagem de Turmas**: Visualize a lista de turmas existentes e realize operações como editar ou excluir. :clipboard:
- **Cadastro de Matrículas**: Adicione novas matrículas para alunos associando-os a turmas. :pencil:
- **Listagem de Matrículas**: Visualize a lista de matrículas existentes e realize operações como editar ou excluir. :clipboard:
