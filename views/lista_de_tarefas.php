<?php
session_start();
require_once('../includes/conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../controllers/login.php');
    exit();
}

$primeiroNome = explode(' ', trim($_SESSION['usuario_nome']))[0];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas com Prazo</title>
    <link rel="stylesheet" href="../css/lista_de_tarefas.css">
</head>

<body>
    <div class="top-bar">
        <div class="user-info">
            <div class="foto-nome">
                <img src="../imagens/Foto-padrão.png" id="fotoPerfil" alt="Foto de Perfil">
                <div class="usuario-nome"><?php echo htmlspecialchars($primeiroNome); ?></div>
            </div>
            <label for="uploadFoto">Trocar foto</label>
            <input type="file" id="uploadFoto" accept="image/*">
        </div>

        <!-- Botão sair fora da user-info -->
        <div class="logout">
            <form method="post" action="../controllers/logout.php">
                <button type="submit" id="sairBtn">Sair</button>
            </form>
        </div>
    </div>



    <div class="todo-container">
        <h1>Minha Lista de Tarefas</h1>

        <form id="todo-form">
            <input type="text" id="tarefa" placeholder="Digite uma nova tarefa..." required>

            <label class="checkbox-inline">
                <input type="checkbox" id="comPrazo"> Possui prazo?
            </label>

            <div class="prazo-inputs">
                <div class="campo-data">
                    <label for="dataInicio">Data de Início</label>
                    <input type="date" id="dataInicio" name="dataInicio">
                </div>
                <div class="campo-data">
                    <label for="dataFim">Data de Fim</label>
                    <input type="date" id="dataFim" name="dataFim">
                </div>
            </div>

            <button type="submit">Adicionar</button>
        </form>

        <ul id="lista-tarefas">
            <!-- Tarefas inseridas aqui dinamicamente -->
        </ul>
    </div>

    <script src="../JS/lista_de_tarefas.js"></script>
</body>

</html>