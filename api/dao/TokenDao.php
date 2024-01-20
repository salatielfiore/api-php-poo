<?php
include_once __DIR__ . "/../db/Db.php";

class TokenDao
{
    const SAVE_TOKEN_USER = "INSERT INTO usuario_token (token, generatedAt, ativo, expires_in, id_usuario) 
            VALUES (:token, :generatedAt, :ativo, :expiresIn, :idUsuario)";
    const DESTIVAR_TOKEN_USUARIO = "UPDATE usuario_token SET ativo = false WHERE id_usuario = :idUsuario";

    /**
     * @throws Exception
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
     * @throws Exception
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


}