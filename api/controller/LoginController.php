<?php
global $id, $api, $method;
include_once __DIR__ . "/../service/UsuarioService.php";
include_once __DIR__ . "/../utils/JsonUtils.php";
include_once __DIR__ . "/../../biblioteca/jwt/jwt.php";
include_once __DIR__ . "/../model/Usuario.php";


if ($api == 'autenticar') {
    $loginController = new LoginController();
    if ($method == "POST") {
        try {
            $loginController->login();
        } catch (Exception $e) {
        }
        exit();
    }

    ErroMessageResponse::notFoundErro('error_not_found');
    exit;
}

class LoginController
{
    /**
     * @throws Exception
     */
    public function login()
    {
        global $acao, $param;
        if ($acao == "login" && $param == '') {
            $usuarioService = new UsuarioService();
            $data = $this->obterDadosLogin();
            $usuarioService->login($data['email'], $data['senha']);
        }

    }

    private function obterDadosLogin()
    {
        $data = JsonUtils::pegarDadosPostJson();
        JsonUtils::validarDadosPostCliente($data, array('email', 'senha'));
        return $data;
    }
}