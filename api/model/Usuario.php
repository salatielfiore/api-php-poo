<?php

class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $ativo;
    private $senha;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * Preenche os atributos da instância com dados fornecidos.
     *
     * @param array $data Dados a serem mapeados.
     * @return void
     */
    public function preencherDados($data)
    {
        $this->setId(isset($data->id) ? $data->id : null);
        $this->setNome(isset($data->nome) ? $data->nome : null);
        $this->setEmail(isset($data->email) ? $data->email : null);
        $this->setAtivo(isset($data->ativo) ? $data->ativo : null);
        $this->setSenha(isset($data->senha) ? $data->senha : null);
    }
}