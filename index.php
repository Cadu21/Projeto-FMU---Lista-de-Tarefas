<?php
session_start();

// Se o usuário estiver logado, redireciona para lista de tarefas
if (isset($_SESSION['usuario_id'])) {
    header("Location: views/lista_de_tarefas.php");
    exit;
}

// Caso contrário, redireciona para o login
header("Location: /Projeto_Lista_Tarefas/views/login.html");
exit;

