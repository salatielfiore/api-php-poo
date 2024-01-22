<?php
global $id, $api, $method;
include_once __DIR__ . "/../service/UsuarioService.php";
include_once __DIR__ . "/../utils/JsonUtils.php";
include_once __DIR__ . "/../model/Usuario.php";

class LoginController
{
    /**
     * @throws Exception
     */
    public function login()
    {
        $usuarioService = new UsuarioService();
        $data = $this->obterDadosLogin();
        $usuarioService->login($data['email'], $data['senha']);
    }

    private function obterDadosLogin()
    {
        $data = JsonUtils::pegarDadosPostJson();
        JsonUtils::validarDadosPostCliente($data, array('email', 'senha'));
        return $data;
    }
}