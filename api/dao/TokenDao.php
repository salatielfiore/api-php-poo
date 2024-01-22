<?php
include_once __DIR__ . "/../db/Db.php";

/**
 * Classe para manipulação de tokens de usuário no banco de dados.
 * @author Salatiel Fiore
 */
class TokenDao
{
    const SAVE_TOKEN_USER = "INSERT INTO usuario_token (token, generatedAt, ativo, expires_in, id_usuario) 
            VALUES (:token, :generatedAt, :ativo, :expiresIn, :idUsuario)";
    const DESTIVAR_TOKEN_USUARIO = "UPDATE usuario_token SET ativo = false WHERE id_usuario = :idUsuario";
    const SELECT_TOKEN = "select * from usuario_token WHERE token = :token AND ativo = true";

    /**
     * Salva um novo token de usuário no banco de dados.
     *
     * @param int $idUsuario ID do usuário associado ao token.
     * @param string $token Token a ser salvo.
     * @param int $expiresIn Tempo de expiração do token.
     * @throws Exception Se ocorrer um erro durante a operação.
     */
    public function salvarToken($idUsuario, $token, $expiresIn)
    {
        global $messages;
        try {
            $ativo = true;
            $generatedAt = date('Y-m-d H:i:s');
            $db = DB::connect();
            $stmt = $db->prepare(self::SAVE_TOKEN_USER);
            // Bind dos parâmetros
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':generatedAt', $generatedAt);
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_BOOL);
            $stmt->bindParam(':expiresIn', $expiresIn, PDO::PARAM_INT);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

            // Executar a instrução SQL
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }

    /**
     * Desativa o token associado a um usuário no banco de dados.
     *
     * @param int $idUsuario ID do usuário.
     * @throws Exception Se ocorrer um erro durante a operação.
     */
    public function desativarTokenUsuario($idUsuario)
    {
        global $messages;
        try {
            $db = Db::connect();
            // Prepara a query de update
            $rs = $db->prepare(self::DESTIVAR_TOKEN_USUARIO);
            // Define os parâmetros da query
            $rs->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            // Executa a query
            $rs->execute();
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }

    /**
     * Busca um token de usuário no banco de dados com base no token fornecido.
     *
     * @param string $token Token a ser buscado.
     * @return Token|null Objeto Token se encontrado, ou null se não encontrado.
     * @throws Exception Se ocorrer um erro durante a operação.
     */
    public function buscarToken($token)
    {
        global $messages;
        try {
            $db = DB::connect();
            $rs = $db->prepare(self::SELECT_TOKEN);
            $rs->bindParam(':token', $token);
            $rs->execute();
            $tokenUsuarioData = $rs->fetchObject();
            $tokenUsuario = new Token();
            $tokenUsuario->preencherDados($tokenUsuarioData);
            return $tokenUsuario;
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }
}