<?php
require_once(__DIR__ . '/../includes/conexao.php');

function cadastrarUsuario($dados)
{
    global $conn;

    // Extrair e sanitizar os dados
    $nome = trim($dados['nome']);
    $email = trim($dados['email']);
    $senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
    $genero = $dados['genero'];
    $cpf = preg_replace('/\D/', '', $dados['cpf']);
    $data_nascimento = $dados['dataNascimento'];
    $cns = preg_replace('/\D/', '', $dados['cns']);
    $cep = preg_replace('/\D/', '', $dados['cep']);
    $endereco = trim($dados['logradouro']);
    $numero = trim($dados['numero']);
    $complemento = isset($dados['complemento']) ? trim($dados['complemento']) : null;
    $bairro = trim($dados['bairro']);
    $cidade = trim($dados['cidade']);
    $estado = $dados['estado'];

    // Preparar SQL
    $sql = "INSERT INTO usuarios (
                nome, email, senha, genero, cpf,
                data_nascimento, cns, cep, endereco, numero,
                complemento, bairro, cidade, estado, data_criacao_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssss",
        $nome,
        $email,
        $senha,
        $genero,
        $cpf,
        $data_nascimento,
        $cns,
        $cep,
        $endereco,
        $numero,
        $complemento,
        $bairro,
        $cidade,
        $estado
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '../views/login.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conn) . "'); history.back();</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Se o método for POST, processar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cadastrarUsuario($_POST);
}
