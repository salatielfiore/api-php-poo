<?php
include_once __DIR__ . "/../dao/ClienteDAO.php";
include_once __DIR__ . "/../comons/Response.php";
include_once __DIR__ . "/../comons/HttpStatus.php";

/**
 * Classe ClienteService para fornecer serviços relacionados a clientes.
 */
class ClienteService
{

    /**
     * Lista todos os clientes.
     *
     * @return void
     */
    public function listarClientes()
    {
        global $messages;
        try {
            $clienteDao = new ClienteDAO();
            $obj = $clienteDao->listarClientes();
            echo json_encode(Response::responseData(HttpStatus::$OK_STATUS, null, $obj));
            exit();
        } catch (Exception $e) {
            echo json_encode(Response::responseError(
                HttpStatus::$INTERNAL_SERVER_ERROR_STATUS, $messages['error_server'], HttpStatus::$INTERNAL_SERVER_ERROR_VALUE));
        }
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param int|string $id O ID do cliente a ser buscado.
     * @return void
     */
    public function buscarPorId($id)
    {
        global $messages;
        try {
            if (!is_numeric($id)) {
                echo json_encode(Response::responseError(
                    HttpStatus::$BAD_REQUEST_STATUS, $messages['invalid_id'], HttpStatus::$BAD_REQUEST_VALUE));
                exit();
            }
            $clienteDao = new ClienteDAO();
            $obj = $clienteDao->buscarClientePorId($id);
            echo json_encode(Response::responseData(HttpStatus::$OK_STATUS, null, $obj));
        } catch (Exception $e) {
            echo json_encode(Response::responseError(
                HttpStatus::$INTERNAL_SERVER_ERROR_STATUS, $messages['error_server'], HttpStatus::$INTERNAL_SERVER_ERROR_VALUE));
        }
    }

}