<?php
global $messages, $id;
include_once __DIR__ . "/../service/ClienteService.php";
global $api, $method;

/**
 * Controlador principal para manipulação de clientes.
 */
if ($api == 'clientes') {
    $clienteController = new ClienteController();
    if ($method == "GET") {
        $clienteController->listarClientes();
        $clienteController->buscarPorId($id);
    }
    if ($method == "POST") {

    }

    echo json_encode(Response::responseError(
        HttpStatus::$NOT_FOUND_STATUS, $messages['error_not_found'], HttpStatus::$NOT_FOUND_VALUE));
    exit;
}

/**
 * Controlador para operações relacionadas a clientes.
 */
class ClienteController
{
    /**
     * Lista todos os clientes.
     *
     * @return void
     */
    public function listarClientes()
    {
        global $acao, $param;
        if ($acao == 'lista' && $param == '') {
            $clienteService = new ClienteService();
            $clienteService->listarClientes();
            exit();
        }
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param string $id O ID do cliente a ser buscado.
     * @return void
     */
    public function buscarPorId($id)
    {
        global $acao;
        if ($acao == 'buscar' && $id != '') {
            $clienteService = new ClienteService();
            $clienteService->buscarPorId($id);
            exit();
        }
    }
}