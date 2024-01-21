<?php

class Token
{
    private $id;
    private $token;
    private $generatedAt;
    private $ativo;
    private $idUsuario;
    private $expiresIn;

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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getGeneratedAt()
    {
        return $this->generatedAt;
    }

    /**
     * @param mixed $generatedAt
     */
    public function setGeneratedAt($generatedAt)
    {
        $this->generatedAt = $generatedAt;
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
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param mixed $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
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
        $this->setToken(isset($data->token) ? $data->token : null);
        $this->setGeneratedAt(isset($data->generatedAt) ? $data->generatedAt : null);
        $this->setAtivo(isset($data->ativo) ? $data->ativo : null);
        $this->setIdUsuario(isset($data->id_usuario) ? $data->id_usuario : null);
        $this->setExpiresIn(isset($data->expires_in) ? $data->expires_in : null);
    }

}