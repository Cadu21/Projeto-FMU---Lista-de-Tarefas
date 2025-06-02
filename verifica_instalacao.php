<?php require_once('verifica_instalacao.php');
// configurações de conexão
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'lista_tarefas'; // substitua pelo nome do seu banco

try {
    // Tenta conectar sem selecionar banco
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '$db'");
    if ($stmt->rowCount() == 0) {
        header('Location: installer.php');
        exit;
    }

    // Se banco existir, conecta normalmente
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
