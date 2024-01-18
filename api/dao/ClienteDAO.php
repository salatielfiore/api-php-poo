<?php
include_once __DIR__ . "/../db/Db.php";

/**
 * Classe ClienteDAO para manipulação de dados relacionados a clientes no banco de dados.
 * @author Salatiel Fiore
 */
class ClienteDAO
{
    const SELECT_ALL_CLIENTES = "SELECT * FROM clientes ORDER BY nome";
    const SELECT_CLIENTE_BY_ID = "SELECT * FROM clientes WHERE id = :id";

    /**
     * Lista todos os clientes no banco de dados.
     *
     * @return array Retorna um array associativo contendo todos os clientes.
     * @throws Exception Lança uma exceção em caso de erro na execução da consulta.
     */
    public function listarClientes()
    {
        global $messages;
        try {
            $db = Db::connect();
            $rs = $db->prepare(self::SELECT_ALL_CLIENTES);
            $rs->execute();
            return $rs->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Adicione log ou mensagem informativa aqui
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param int $id O ID do cliente a ser buscado.
     * @return object|null Retorna um objeto contendo os dados do cliente ou null se o cliente não for encontrado.
     * @throws Exception Lança uma exceção em caso de erro na execução da consulta.
     */
    public function buscarClientePorId($id)
    {
        global $messages;
        try {
            $db = DB::connect();
            $rs = $db->prepare(self::SELECT_CLIENTE_BY_ID);
            $rs->bindParam(':id', $id, PDO::PARAM_INT);
            $rs->execute();
            // Chame fetchObject uma vez e atribua o resultado a uma variável
            $cliente = $rs->fetchObject();
            // Use a variável $cliente no retorno
            return $cliente ?: null;
        } catch (Exception $e) {
            throw new Exception($messages['error_server'] . $e->getMessage());
        }
    }

}