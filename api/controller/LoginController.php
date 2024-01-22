<?php
global $id, $api, $method;
include_once __DIR__ . "/../service/UsuarioService.php";
include_once __DIR__ . "/../utils/JsonUtils.php";
include_once __DIR__ . "/../model/Usuario.php";

/**
 * Controlador para operações relacionadas ao login de usuários.
 * @author Salatiel Fiore
 */
class LoginController
{
    /**
     * Realiza o processo de login do usuário.
     *
     * @throws Exception Se ocorrer um erro durante o processo de login.
     */
    public function login()
    {
        $usuarioService = new UsuarioService();
        $data = $this->obterDadosLogin();
        $usuarioService->login($data['email'], $data['senha']);
    }

    /**
     * Obtém os dados de login a partir do corpo da requisição.
     *
     * @return array Dados de login, incluindo email e senha.
     */
    private function obterDadosLogin()
    {
        $data = JsonUtils::pegarDadosPostJson();
        JsonUtils::validarDadosPostCliente($data, array('email', 'senha'));
        return $data;
    }
}