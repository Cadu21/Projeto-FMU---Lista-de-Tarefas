<?php

// Conexão com o banco de dados (ajustado para projeto Lista de Tarefas)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lista_tarefas";

// Obtém os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta segura com prepared statement
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica se a senha digitada bate com o hash
    if (password_verify($senha, $row['senha'])) {
        session_start();
        $_SESSION['usuario_id'] = $row['id_usuario']; // ou apenas 'id'
        $_SESSION['usuario_nome'] = $row['nome'];

        header("Location: ../views/lista_de_tarefas.php"); // direciona para a página principal
        exit();
    } else {
        echo "<script>alert('Senha incorreta!');history.back();</script>";
    }
} else {
    echo "<script>alert('Usuário não encontrado!');history.back();</script>";
}

$conn->close();
}


