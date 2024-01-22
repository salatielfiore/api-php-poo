<?php
include_once __DIR__ . "/../db/Db.php";

/**
 * Classe para manipulação de usuários no banco de dados.
 * @author Salatiel Fiore
 */
class UsuarioDao
{
    const SELECT_USUARIO_BY_EMAIL = "SELECT * FROM usuario WHERE email = :email";

    /**
     * Busca um usuário no banco de dados com base no endereço de e-mail.
     *
     * @param string $email Endereço de e-mail do usuário a ser buscado.
     * @return Usuario|null Objeto Usuário se encontrado, ou null se não encontrado.
     * @throws Exception Se ocorrer um erro durante a operação.
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
            return $usuario;
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }
}