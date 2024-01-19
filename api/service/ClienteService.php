<?php
include_once __DIR__ . "/../dao/ClienteDAO.php";

/**
 * Classe ClienteService para fornecer serviços relacionados a clientes.
 * @author Salatiel Fiore
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
        try {
            $clienteDao = new ClienteDAO();
            $obj = $clienteDao->listarClientes();
            echo json_encode(Response::responseData(HttpStatus::OK_STATUS, null, $obj));
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::notFoundErro('error_not_found');
            exit();
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
        try {
            if (!is_numeric($id)) {
                ErroMessageResponse::badRequestErro('error_invalid_id');
                exit();
            }
            $clienteDao = new ClienteDAO();
            $obj = $clienteDao->buscarClientePorId($id);
            echo json_encode(Response::responseData(HttpStatus::OK_STATUS, null, $obj));
        } catch (Exception $e) {
            ErroMessageResponse::internalServerErro();
            exit();
        }
    }

    /**
     * Salva um novo cliente no banco de dados.
     *
     * @param Cliente $cliente Os dados do cliente a serem salvos.
     * @return void
     * @throws Exception Lançada em caso de erro durante a operação.
     */
    public function salvarCliente(Cliente $cliente)
    {
        global $messages;
        try {
            $this::validarCliente($cliente);
            $clienteDao = new ClienteDAO();
            $clienteDao->salvarCliente($cliente);
            echo json_encode(Response::responseData(
                HttpStatus::OK_STATUS, $messages['success_save_cliente'], null));
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::badRequestErro('error_save_client');
            exit();
        }
    }

    /**
     * Valida os dados de um objeto Cliente.
     *
     * @param Cliente $cliente Objeto Cliente a ser validado.
     * @return void
     */
    private function validarCliente(Cliente $cliente)
    {
        $nome = $cliente->getNome();
        $telefone = $cliente->getTelefone();
        if (empty($nome)) {
            ErroMessageResponse::badRequestErro('error_campo_nome_vazio');
            exit();
        }

        if (strlen($nome) > 50) {
            ErroMessageResponse::badRequestErro('error_campo_nome_tamanho');
            exit();
        }

        if (empty($telefone)) {
            ErroMessageResponse::badRequestErro('error_campo_telefone_vazio');
            exit();
        }

        if (strlen($telefone) !== 11) {
            ErroMessageResponse::badRequestErro('error_campo_telefone_tamanho');
            exit();
        }
    }
}