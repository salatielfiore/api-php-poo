<?php
include_once __DIR__ . "/../dao/UsuarioDao.php";
include_once __DIR__ . "/../dao/TokenDao.php";
include_once __DIR__ . "/../model/Token.php";
include_once __DIR__ . "/../../biblioteca/jwt/jwt.php";
include_once __DIR__ . "/../../biblioteca/password_compact/password.php";

/**
 * Serviço para autenticação e geração de tokens de usuário.
 * @author Salatiel Fiore
 */
class UsuarioService
{

    /**
     * Realiza o processo de login, autenticação e geração de token.
     *
     * @param string $email Endereço de e-mail do usuário.
     * @param string $senha Senha do usuário.
     * @throws Exception Se ocorrer um erro durante o processo.
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

    /**
     * Valida o token JWT enviado nas requisições.
     *
     * @throws Exception Se ocorrer um erro durante a validação.
     */
    public function validarJWT()
    {
        try {
            $headers = apache_request_headers();
            if (!isset($headers['Authorization'])) {
                ErroMessageResponse::forbiddenErro();
                exit();
            }
            $dataHeaderAuthorization = explode(" ", $headers['Authorization']);
            $this::validarHeaderAuthorization($dataHeaderAuthorization);
            $jwtToken = $dataHeaderAuthorization[1];
            $tokenDao = new TokenDao();
            $tokenUsuario = $tokenDao->buscarToken($jwtToken);
            $this::validarToken($tokenUsuario);
        } catch (Exception $e) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }

    }

    /**
     * Valida o token JWT obtido do banco de dados.
     *
     * @param Token $tokenUsuario Objeto Token contendo as informações do token.
     * @throws Exception Se ocorrer um erro durante a validação.
     */
    private static function validarToken(Token $tokenUsuario)
    {
        global $config;
        $secretJWT = $config['secretJWT'];
        $decodedJWT = JWT::decode($tokenUsuario->getToken(), $secretJWT);
        if (!$decodedJWT->id == $tokenUsuario->getIdUsuario()) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }
        if ($tokenUsuario->getId() === null) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }

        if ($tokenUsuario->getExpiresIn() < time()) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }

        if (!$tokenUsuario->getAtivo()) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }
    }

    /**
     * Valida a estrutura do cabeçalho 'Authorization' da requisição.
     *
     * @param array $dataHeaderAuthorization Dados do cabeçalho 'Authorization'.
     * @throws Exception Se ocorrer um erro durante a validação.
     */
    private static function validarHeaderAuthorization(array $dataHeaderAuthorization)
    {
        if (empty($dataHeaderAuthorization[0]) || empty($dataHeaderAuthorization[1])) {
            ErroMessageResponse::forbiddenErro();
            exit();
        }

        if ($dataHeaderAuthorization[0] !== "Bearer") {
            ErroMessageResponse::forbiddenErro();
            exit();
        }

    }

    /**
     * Valida os dados fornecidos durante o processo de login.
     *
     * @param string $email Endereço de e-mail do usuário.
     * @param string $senha Senha do usuário.
     * @param Usuario $usuario Objeto Usuario obtido do banco de dados.
     * @throws Exception Se ocorrer um erro durante a validação.
     */
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
     * Retorna o token JWT e o tempo de expiração em formato JSON.
     *
     * @param string $token Token JWT gerado.
     * @param int $expire_in Tempo de expiração do token.
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
     * Gera o token JWT para o usuário.
     *
     * @param Usuario $usuario Objeto Usuario contendo as informações do usuário.
     * @param int $expireIn Tempo de expiração do token.
     * @return string Token JWT gerado.
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