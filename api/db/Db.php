<?php

/**
 * Classe Db para lidar com a conexão ao banco de dados.
 * @author Salatiel Fiore
 */
class Db
{
    /**
     * Estabelece uma conexão com o banco de dados e retorna um objeto PDO.
     *
     * @return PDO Uma instância do objeto PDO representando a conexão com o banco de dados.
     * @throws PDOException Lançada em caso de falha na conexão com o banco de dados.
     */
    public static function connect()
    {
        global $config;
        try {
            $host = $config['dbHost'];
            $user = $config['dbUser'];
            $password = $config['dbPassword'];
            $banco = $config['dbName'];
            return new PDO("mysql:host=$host;dbname=$banco;charset=UTF8;", $user, $password);
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}