<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "lista_tarefas";

$conn = new mysqli($host, $usuario, $senha);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

// Criar banco
if (!$conn->query("CREATE DATABASE IF NOT EXISTS $banco")) {
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao criar banco: " . $conn->error]);
    exit;
}

$conn->select_db($banco);

// Criar tabela usuarios
$sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    genero VARCHAR(10) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    cns VARCHAR(15) NOT NULL,
    cep VARCHAR(8) NOT NULL,
    endereco VARCHAR(60) NOT NULL,
    numero INT NOT NULL,
    complemento VARCHAR(60),
    bairro VARCHAR(60) NOT NULL,
    cidade VARCHAR(60) NOT NULL,
    estado CHAR(2) NOT NULL,
    data_criacao_registro DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sqlUsuarios)) {
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao criar tabela usuarios: " . $conn->error]);
    exit;
}

// Criar tabela tarefas
$sqlTarefas = "CREATE TABLE IF NOT EXISTS tarefas (
    id_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nome_tarefa VARCHAR(60) NOT NULL,
    possui_prazo BOOLEAN NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    tarefa_concluida BOOLEAN DEFAULT FALSE,
    data_criacao_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
)";
if (!$conn->query($sqlTarefas)) {
    http_response_code(500);
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao criar tabela tarefas: " . $conn->error]);
    exit;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(["status" => "ok", "mensagem" => "Instalação concluída com sucesso"]);

?>
