<?php require_once(__DIR__ . '/../includes/verifica_instalacao.php');

session_start();
session_unset();  // Limpa as variáveis de sessão
session_destroy(); // Destrói a sessão

header("Location: ../views/login.html"); // Redireciona para o login
exit();
