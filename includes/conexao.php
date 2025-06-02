<?php require_once('verifica_instalacao.php');

$host = "localhost";
$usuario = "root";
$senha = ""; // ou "123" se estiver usando senha no XAMPP
$banco = "lista_tarefas";

// Criar conexão
$conn = mysqli_connect($host, $usuario, $senha, $banco);

// Verificar conexão
if (!$conn) {
    die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
}
