<?php
header('Content-Type: application/json');
require_once('../includes/verifica_instalacao.php');
include_once(__DIR__ . '/../includes/conexao.php');

function listarTarefasPorUsuario($id_usuario)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM tarefas WHERE id_usuario = ? ORDER BY data_criacao_registro DESC");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    return $stmt->get_result();
}

function adicionarTarefa($id_usuario, $nome_tarefa, $possui_prazo, $data_inicio, $data_fim)
{
    global $conn;
    $possui_prazo = $possui_prazo ? 1 : 0;
    $tarefa_concluida = 0;
    if (!$possui_prazo) {
        $data_inicio = null;
        $data_fim = null;
    }
    $stmt = $conn->prepare("INSERT INTO tarefas (id_usuario, nome_tarefa, possui_prazo, data_inicio, data_fim, tarefa_concluida, data_criacao_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isissi", $id_usuario, $nome_tarefa, $possui_prazo, $data_inicio, $data_fim, $tarefa_concluida);
    return $stmt->execute();
}

function editarTarefa($id_tarefa, $tarefa_concluida)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE tarefas SET tarefa_concluida = ? WHERE id_tarefa = ?");
    $stmt->bind_param("ii", $tarefa_concluida, $id_tarefa);
    $stmt->execute();
}

function atualizarPrazo($id_tarefa, $data_inicio, $data_fim)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE tarefas SET data_inicio = ?, data_fim = ?, possui_prazo = 1 WHERE id_tarefa = ?");
    $stmt->bind_param("ssi", $data_inicio, $data_fim, $id_tarefa);
    return $stmt->execute();
}

function excluirTarefa($id_tarefa)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id_tarefa = ?");
    $stmt->bind_param("i", $id_tarefa);
    $stmt->execute();
}

session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if ($acao === 'adicionar') {
        $nome_tarefa = trim($_POST['nome_tarefa'] ?? '');
        $possui_prazo = isset($_POST['possui_prazo']) ? (bool)$_POST['possui_prazo'] : false;
        $data_inicio = !empty($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
        $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;

        $check = $conn->prepare("SELECT COUNT(*) as total FROM tarefas WHERE id_usuario = ? AND nome_tarefa = ?");
        $check->bind_param("is", $id_usuario, $nome_tarefa);
        $check->execute();
        $result = $check->get_result()->fetch_assoc();

        if ($result && $result['total'] > 0) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Tarefa já existe!']);
            exit;
        }

        $inseriu = adicionarTarefa($id_usuario, $nome_tarefa, $possui_prazo, $data_inicio, $data_fim);

        if ($inseriu) {
            $last_id = $conn->insert_id;
            $stmt = $conn->prepare("SELECT * FROM tarefas WHERE id_tarefa = ?");
            $stmt->bind_param("i", $last_id);
            $stmt->execute();
            $tarefa = $stmt->get_result()->fetch_assoc();

            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Tarefa adicionada com sucesso!', 'tarefa' => $tarefa]);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao inserir no banco']);
        }
        exit;
    }

    if ($acao === 'excluir') {
        $id_tarefa = $_POST['id_tarefa'];
        $verifica = $conn->prepare("SELECT * FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
        $verifica->bind_param("ii", $id_tarefa, $id_usuario);
        $verifica->execute();
        if (!$verifica->get_result()->fetch_assoc()) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado.']);
            exit;
        }
        excluirTarefa($id_tarefa);
        echo json_encode(['status' => 'sucesso']);
        exit;
    }

    if ($acao === 'concluir') {
        $id_tarefa = $_POST['id_tarefa'];
        $verifica = $conn->prepare("SELECT * FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
        $verifica->bind_param("ii", $id_tarefa, $id_usuario);
        $verifica->execute();
        if (!$verifica->get_result()->fetch_assoc()) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado.']);
            exit;
        }
        editarTarefa($id_tarefa, 1);
        echo json_encode(['status' => 'sucesso']);
        exit;
    }

    if ($acao === 'editar') {
        $id_tarefa = $_POST['id_tarefa'];
        $data_inicio = $_POST['data_inicio'] ?? null;
        $data_fim = $_POST['data_fim'] ?? null;

        $verifica = $conn->prepare("SELECT * FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
        $verifica->bind_param("ii", $id_tarefa, $id_usuario);
        $verifica->execute();
        if (!$verifica->get_result()->fetch_assoc()) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado.']);
            exit;
        }

        $ok = atualizarPrazo($id_tarefa, $data_inicio, $data_fim);
        echo json_encode(['status' => $ok ? 'sucesso' : 'erro']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tarefas = listarTarefasPorUsuario($id_usuario);
    $resultado = [];
    while ($row = $tarefas->fetch_assoc()) {
        $resultado[] = $row;
    }
    echo json_encode(['status' => 'sucesso', 'tarefas' => $resultado]);
    exit;
}
