<?php
include_once __DIR__ . "/../db/Db.php";

class UsuarioDao
{
    const SELECT_USUARIO_BY_EMAIL = "SELECT * FROM usuario WHERE email = :email";

    /**
     * @throws Exception
     */
    public function buscarUsuarioPorEmail($email)
    {
        global $messages;
        try {
            $db = DB::connect();
            $rs = $db->prepare(self::SELECT_USUARIO_BY_EMAIL);
            $rs->bindParam(':email', $email);
            $rs->execute();
            $usuarioData = $rs->fetchObject();
            $usuario = new Usuario();
            $usuario->preencherDados($usuarioData);
            return $usuarioData ? $usuario : new Usuario();
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }


}