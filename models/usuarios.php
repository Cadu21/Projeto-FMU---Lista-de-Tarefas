<?php require_once('verifica_instalacao.php');
class Usuario
{
    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $genero;
    public $cpf;
    public $data_nascimento;
    public $cns;
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;
    public $data_criacao_registro;

    public function __construct(
        $id_usuario,
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
        $estado,
        $data_criacao_registro
    ) {
        $this->id_usuario            = $id_usuario;
        $this->nome                  = $nome;
        $this->email                 = $email;
        $this->senha                 = $senha;
        $this->genero                = $genero;
        $this->cpf                   = $cpf;
        $this->data_nascimento       = $data_nascimento;
        $this->cns                   = $cns;
        $this->cep                   = $cep;
        $this->endereco              = $endereco;
        $this->numero                = $numero;
        $this->complemento           = $complemento;
        $this->bairro                = $bairro;
        $this->cidade                = $cidade;
        $this->estado                = $estado;
        $this->data_criacao_registro = $data_criacao_registro;
    }
}
