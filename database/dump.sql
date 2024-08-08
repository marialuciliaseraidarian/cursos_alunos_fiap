-- Criação do banco de dados 
CREATE DATABASE fiap_cursos_alunos
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

-- Selecionar o banco de dados
USE fiap_cursos_alunos;

-- Criação das tabelas 

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(250) NOT NULL, 
    data_nascimento DATE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(250) NOT NULL,
    descricao TEXT,
    tipo VARCHAR(50) NOT NULL
);

CREATE TABLE matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (turma_id) REFERENCES turmas(id),
    UNIQUE (aluno_id, turma_id)
);

-- Inserção de dados

INSERT INTO alunos (nome, data_nascimento, usuario) VALUES
('Ana Silva', '1990-01-15', 'ana.silva'),
('Bruno Souza', '1988-05-22', 'bruno.souza'),
('Carla Mendes', '1992-07-08', 'carla.mendes'),
('Daniel Lima', '1995-12-10', 'daniel.lima'),
('Eduardo Pereira', '1987-03-18', 'eduardo.pereira'),
('Fernanda Costa', '1993-04-25', 'fernanda.costa'),
('Gabriel Santos', '1991-11-30', 'gabriel.santos'),
('Helena Almeida', '1994-09-14', 'helena.almeida'),
('Igor Martins', '1989-06-05', 'igor.martins'),
('Juliana Ferreira', '1996-08-20', 'juliana.ferreira');

INSERT INTO turmas (nome, descricao, tipo) VALUES
('Turma A', 'Turma de Introdução ao PHP', 'Presencial'),
('Turma B', 'Turma de Desenvolvimento Web', 'Online'),
('Turma C', 'Turma de Banco de Dados', 'Presencial'),
('Turma D', 'Turma de Segurança da Informação', 'Online'),
('Turma E', 'Turma de Programação em Java', 'Presencial');

INSERT INTO matriculas (aluno_id, turma_id) VALUES
(1, 1), 
(2, 1), 
(3, 1), 
(4, 2), 
(5, 2), 
(6, 2), 
(7, 3), 
(8, 3), 
(9, 3), 
(10, 4),
(1, 4), 
(2, 4), 
(3, 5), 
(4, 5), 
(5, 5);

