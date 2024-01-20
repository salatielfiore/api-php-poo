<?php
include_once __DIR__ . "/../dao/UsuarioDao.php";
include_once __DIR__ . "/../dao/TokenDao.php";
include_once __DIR__ . "/../../biblioteca/password_compact/password.php";

class UsuarioService
{

    /**
     * @throws Exception
     */
    public function login($email, $senha)
    {
        try {
            $email = addslashes(htmlspecialchars($email)) ?: '';
            $senha = addslashes(htmlspecialchars($senha)) ?: '';

            $usuarioDao = new UsuarioDao();
            $usuario = $usuarioDao->buscarUsuarioPorEmail($email);

            $this::validarDadosLogin($email, $senha, $usuario);

            $expireIn = time() + 300;

            $token = $this->getTokenUser($usuario, $expireIn);

            $tokenDao = new TokenDao();
            $tokenDao->desativarTokenUsuario($usuario->getId());
            $tokenDao->salvarToken($usuario->getId(), $token, $expireIn);

            $this->responseTokenAndRefresh($token, $expireIn);
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::internalServerErro();
            exit();
        }

    }

    private function validarDadosLogin($email, $senha, Usuario $usuario)
    {
        if (empty($email)) {
            ErroMessageResponse::unauthorizedErro('error_campo_email_vazio');
            exit();
        }

        if (empty($senha)) {
            ErroMessageResponse::unauthorizedErro('error_campo_senha_vazio');
            exit();
        }

        $validPassword = password_verify($senha, $usuario->getSenha());
        if ($usuario->getId() === null || !$validPassword) {
            ErroMessageResponse::unauthorizedErro('error_credencial_invalida');
            exit();
        }

        if (!$usuario->getAtivo()) {
            ErroMessageResponse::unauthorizedErro('error_usuario_inativo');
            exit();
        }
    }

    /**
     * @param $token
     * @param $expire_in
     * @return void
     */
    public function responseTokenAndRefresh($token, $expire_in)
    {
        echo json_encode(array(
            "token" => $token,
            "expireIn" => $expire_in
        ));
    }

    /**
     * @param Usuario $usuario
     * @param $expireIn
     * @return string
     */
    public function getTokenUser(Usuario $usuario, $expireIn)
    {
        global $config;
        return JWT::encode(array(
            'id' => $usuario->getId(),
            'name' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
            'expireIn' => $expireIn,
        ), $config['secretJWT']);
    }
}