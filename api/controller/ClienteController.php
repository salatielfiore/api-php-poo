<?php
global $id, $api, $method;
include_once __DIR__ . "/../service/ClienteService.php";
include_once __DIR__ . "/../service/UsuarioService.php";
include_once __DIR__ . "/../model/Cliente.php";
include_once __DIR__ . "/../utils/JsonUtils.php";
include_once __DIR__ . "/../utils/StringUtils.php";

/**
 * Controlador para operações relacionadas a clientes.
 * @author Salatiel Fiore
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
        $clienteService = new ClienteService();
        $clienteService->listarClientes();
        exit();
    }

    /**
     * Busca um cliente pelo ID.
     *
     * @param array $params paramentros que vem na url do usuario.
     * @return void
     */
    public function buscarPorId($params)
    {
        $id = $params["id"];
        $clienteService = new ClienteService();
        $obj = $clienteService->buscarPorId($id);
        echo json_encode(Response::responseData(HttpStatus::OK_STATUS, null, $obj));
        exit();
    }

    /**
     * Salva um novo cliente, obtendo os dados do cliente a partir da requisição.
     *
     * @return void
     * @throws Exception
     */
    public function salvarCliente()
    {
        $clienteService = new ClienteService();
        $cliente = $this::obterDadosCliente();
        $clienteService->salvarCliente($cliente);
    }

    /**
     * Atualiza um cliente existente, obtendo os dados do cliente a partir da requisição.
     *
     * @return void
     */
    public function atualizarCliente($params)
    {
        $clienteService = new ClienteService();
        $cliente = $this::obterDadosCliente();
        $cliente->setId($params["pathVariable"]);
        $clienteService->editarCliente($cliente);
    }

    /**
     * Exclui um cliente com base no ID fornecido.
     *
     * @param array $params Parâmetros da rota, incluindo o ID do cliente.
     */
    public function excluirCliente($params)
    {
        $id = $params["pathVariable"];
        $clienteService = new ClienteService();
        $clienteService->excluirCliente($id);
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

