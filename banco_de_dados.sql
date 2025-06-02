-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS lista_tarefas;
USE lista_tarefas;

-- Tabela: Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    genero VARCHAR(10) NOT NULL,
    cpf CHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    cns CHAR(15) NOT NULL,
    cep CHAR(8) NOT NULL,
    endereco VARCHAR(60) NOT NULL,
    numero INT(6) NOT NULL,
    complemento VARCHAR(60),
    bairro VARCHAR(60) NOT NULL,
    cidade VARCHAR(60) NOT NULL,
    estado CHAR(2) NOT NULL,
    data_criacao_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Tabela: Tarefas
CREATE TABLE IF NOT EXISTS tarefas (
    id_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nome_tarefa VARCHAR(60) NOT NULL,
    possui_prazo BOOLEAN NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    tarefa_concluida BOOLEAN NOT NULL DEFAULT 0,
    data_criacao_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_tarefa FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
