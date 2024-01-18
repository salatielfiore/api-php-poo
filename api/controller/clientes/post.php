<?php
global $acao, $param;
require_once __DIR__ . "/../../db/Response.php";
require_once "Cliente.php";
require_once "HttpStatus.php";

if ($acao == "adiciona" && $param == '') {
    $cliente = dadosCliente();
    echo json_encode(Response::responseData(HttpStatus::$OK_STATUS, 'Adicionado!', null));
} else {
    echo json_encode(Response::responseError(
        HttpStatus::$NOT_FOUND_STATUS, 'Rota não encontrada!', HttpStatus::$NOT_FOUND_VALUE));
}

function dadosCliente()
{
    $data = pegarDadosPost();
    validarDadosPostCliente($data);
    $cliente = new Cliente();
    $cliente->setNome($data['nome']);
    $cliente->setTelefone($data['telefone']);
    return $cliente;
}

function pegarDadosPost()
{
    // Obtém o conteúdo JSON do corpo da solicitação
    $json_data = file_get_contents("php://input");
    // Decodifica o JSON em um array associativo
    return json_decode($json_data, true);
}

function validarDadosPostCliente($data)
{
    if (!isset($data['nome']) || !isset($data['telefone'])) {
        echo json_encode(Response::responseError(
            HttpStatus::$BAD_REQUEST_STATUS, 'Response JSON Inválido!', HttpStatus::$BAD_REQUEST_VALUE));
        exit();
    }
}