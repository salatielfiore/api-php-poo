<?php
include_once __DIR__ . "/../dao/ClienteDao.php";

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
            $clienteDao = new ClienteDao();
            $obj = $clienteDao->listarClientes();
            echo json_encode(Response::responseData(HttpStatus::OK_STATUS, null, $obj));
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::internalServerErro();
            exit();
        }
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param int|string $id O ID do cliente a ser buscado.
     * @return object
     */
    public function buscarPorId($id)
    {
        try {
            $this->validarId($id);
            $clienteDao = new ClienteDao();
            return $clienteDao->buscarClientePorId($id);
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
            $clienteDao = new ClienteDao();
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
     * Edita um cliente existente.
     *
     * @param Cliente $cliente Objeto Cliente contendo os novos dados.
     * @return void
     */
    public function editarCliente(Cliente $cliente)
    {
        global $messages;
        try {
            $this::validarId($cliente->getId());
            $this::verificarSeExisteClientePorId($cliente->getId());
            $this::validarCliente($cliente);
            $clienteDao = new ClienteDao();
            $clienteDao->atualizarCliente($cliente);
            echo json_encode(Response::responseData(
                HttpStatus::OK_STATUS, $messages['success_save_cliente'], null));
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::badRequestErro('error_save_client');
            exit();
        }
    }

    /**
     * Exclui um cliente existente.
     *
     * @param int $id ID do cliente a ser excluído.
     * @return void
     */
    public function excluirCliente($id)
    {
        global $messages;
        try {
            $this::validarId($id);
            $this::verificarSeExisteClientePorId($id);
            $clienteDao = new ClienteDao();
            $clienteDao->excluirCliente($id);
            echo json_encode(Response::responseData(
                HttpStatus::OK_STATUS, $messages['success_delete_cliente'], null));
            exit();
        } catch (Exception $e) {
            ErroMessageResponse::badRequestErro('error_delete_cliente');
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

    /**
     * Valida se o ID é numérico.
     *
     * @param mixed $id ID a ser validado.
     * @return void
     */
    private function validarId($id)
    {
        if (!is_numeric($id)) {
            ErroMessageResponse::badRequestErro('error_invalid_id');
            exit();
        }
    }

    /**
     * Verifica se um cliente com o ID fornecido existe antes de editar.
     *
     * @param int $id ID do cliente a ser verificado.
     * @return void
     * @throws Exception Em caso de cliente não existir.
     */
    private function verificarSeExisteClientePorId($id)
    {
        $clienteDao = new ClienteDao();
        if (!$clienteDao->existsById($id)) {
            ErroMessageResponse::notFoundErro('error_buscar_cliente');
            exit();
        }
    }
}