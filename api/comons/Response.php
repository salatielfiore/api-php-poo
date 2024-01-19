<?php

/**
 * Classe Response para manipulação de respostas HTTP formatadas.
 * @author Salatiel Fiore
 */
class response
{

    /**
     * Retorna um array formatado para uma resposta de sucesso.
     *
     * @param int $status Código de status HTTP.
     * @param string|null $message Mensagem associada à resposta.
     * @param mixed|null $data Dados associados à resposta.
     * @return array
     */
    static function responseData($status, $message, $data)
    {
        return array(
            "status" => $status,
            "message" => $message,
            "data" => $data
        );
    }

    /**
     * Retorna um array formatado para uma resposta de erro.
     * Define o cabeçalho HTTP correspondente ao código de status.
     *
     * @param int $status Código de status HTTP.
     * @param string|null $message Mensagem associada à resposta de erro.
     * @param string|null $error Descrição do erro.
     * @return array
     */
    static function responseError($status, $message, $error)
    {
        header("HTTP/1.1 $status $error");
        return array(
            "status" => $status,
            "message" => $message,
            "error" => $error
        );
    }
}