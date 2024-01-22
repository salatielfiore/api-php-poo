<?php

/**
 * Classe ErroMessageResponse para lidar com respostas de erro formatadas.
 * @author Salatiel Fiore
 */
class ErroMessageResponse
{

    /**
     * Retorna uma resposta de erro para requisições inválidas (400 Bad Request).
     *
     * @param string $chave_mensagem A chave da mensagem de erro a ser utilizada.
     * @return void
     */
    public static function badRequestErro($chave_mensagem)
    {
        global $messages;
        echo json_encode(Response::responseError(
            HttpStatus::BAD_REQUEST_STATUS, $messages[$chave_mensagem], HttpStatus::BAD_REQUEST_VALUE));
    }

    /**
     * Retorna uma resposta de erro para recursos não encontrados (404 Not Found).
     *
     * @param string $chave_mensagem A chave da mensagem de erro a ser utilizada.
     * @return void
     */
    public static function notFoundErro($chave_mensagem)
    {
        global $messages;
        echo json_encode(Response::responseError(
            HttpStatus::NOT_FOUND_STATUS, $messages[$chave_mensagem], HttpStatus::NOT_FOUND_VALUE));
    }

    /**
     * Retorna uma resposta de erro para erros internos do servidor (500 Internal Server Error).
     *
     * @return void
     */
    public static function internalServerErro()
    {
        global $messages;
        echo json_encode(Response::responseError(
            HttpStatus::INTERNAL_SERVER_ERROR_STATUS, $messages['error_server'], HttpStatus::INTERNAL_SERVER_ERROR_VALUE));
    }

    /**
     * Resposta para erro de autorização não concedida.
     *
     * @param string $chave_mensagem Chave da mensagem de erro.
     */
    public static function unauthorizedErro($chave_mensagem)
    {
        global $messages;
        echo json_encode(Response::responseError(
            HttpStatus::UNAUTHORIZED_STATUS, $messages[$chave_mensagem], HttpStatus::UNAUTHORIZED_VALUE));
    }

    /**
     * Resposta para erro de acesso proibido.
     */
    public static function forbiddenErro()
    {
        $status = HttpStatus::FORBIDDEN_STATUS;
        $error = HttpStatus::FORBIDDEN_VALUE;
        header("HTTP/1.1 $status $error");
    }

}
