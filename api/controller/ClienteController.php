<?php
global $id, $api, $method;
include_once __DIR__ . "/../service/ClienteService.php";
include_once __DIR__ . "/../service/UsuarioService.php";
include_once __DIR__ . "/../model/Cliente.php";
include_once __DIR__ . "/../utils/JsonUtils.php";
include_once __DIR__ . "/../utils/StringUtils.php";

/**
 * Controlador principal para manipulação de clientes.
 */
if ($api == 'clientes') {
    $usuarioService = new UsuarioService();
    $usuarioService->validarJWT();
    $clienteController = new ClienteController();
    if ($method == "GET") {
        $clienteController->listarClientes();
        $clienteController->buscarPorId($id);
    }
    if ($method == "POST") {
        try {
            $clienteController->salvarCliente();
        } catch (Exception $e) {
            ErroMessageResponse::internalServerErro();
        }
    }

    if ($method == "PUT") {
        $clienteController->atualizarCliente();
    }

    if ($method == "DELETE") {
        $clienteController->excluirCliente();
    }

    ErroMessageResponse::notFoundErro('error_not_found');
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
            $obj = $clienteService->buscarPorId($id);
            echo json_encode(Response::responseData(HttpStatus::OK_STATUS, null, $obj));
            exit();
        }
    }

    /**
     * Salva um novo cliente, obtendo os dados do cliente a partir da requisição.
     *
     * @return void
     * @throws Exception
     */
    public function salvarCliente()
    {
        global $acao, $param;
        if ($acao == "salvar" && $param == '') {
            $clienteService = new ClienteService();
            $cliente = $this::obterDadosCliente();
            $clienteService->salvarCliente($cliente);
        }

    }

    /**
     * Atualiza um cliente existente, obtendo os dados do cliente a partir da requisição.
     *
     * @return void
     */
    public function atualizarCliente()
    {
        global $acao, $param;
        if ($acao == "editar" && $param != '') {
            $clienteService = new ClienteService();
            $cliente = $this::obterDadosCliente();
            $cliente->setId($param);
            $clienteService->editarCliente($cliente);
        }
    }

    public function excluirCliente()
    {
        global $acao, $param;
        if ($acao == "excluir" && $param != '') {
            $clienteService = new ClienteService();
            $clienteService->excluirCliente($param);
        }
    }

    /**
     * Obtém e valida os dados do cliente a partir do JSON da requisição POST.
     *
     * @return Cliente Objeto Cliente com os dados validados e formatados.
     */
    private function obterDadosCliente()
    {
        $data = JsonUtils::pegarDadosPostJson();
        JsonUtils::validarDadosPostCliente($data, array('nome', 'telefone'));
        $cliente = new Cliente();
        $telefone = StringUtils::removeMascaraTelefone($data['telefone']);
        $cliente->setNome($data['nome']);
        $cliente->setTelefone($telefone);
        return $cliente;
    }

}

