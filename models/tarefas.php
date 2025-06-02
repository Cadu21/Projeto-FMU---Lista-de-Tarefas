<?php require_once('verifica_instalacao.php');
class Tarefa
{
    public $id_tarefa;
    public $id_usuario;
    public $nome_tarefa;
    public $possui_prazo;
    public $data_inicio;
    public $data_fim;
    public $tarefa_concluida;
    public $data_criacao_registro;

    public function __construct(
        $id_tarefa,
        $id_usuario,
        $nome_tarefa,
        $possui_prazo,
        $data_inicio,
        $data_fim,
        $tarefa_concluida,
        $data_criacao_registro
    ) {
        $this->id_tarefa            = $id_tarefa;
        $this->id_usuario           = $id_usuario;
        $this->nome_tarefa          = $nome_tarefa;
        $this->possui_prazo        = $possui_prazo;
        $this->data_inicio         = $data_inicio;
        $this->data_fim            = $data_fim;
        $this->tarefa_concluida    = $tarefa_concluida;
        $this->data_criacao_registro = $data_criacao_registro;
    }
}
