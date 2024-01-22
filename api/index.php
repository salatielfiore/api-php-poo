<?php
require_once "comons/HttpStatus.php";
include_once "comons/Response.php";
include_once "comons/ErroMessageResponse.php";
include_once "comons/Rotas.php";

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

$messages = json_decode(file_get_contents('messages.json'), true);
$config = json_decode(file_get_contents('config.json'), true);

include_once "controller/ClienteController.php";
include_once "controller/LoginController.php";

$rotas = new Rotas();
$rotas->add("POST", "/autenticar/login", "LoginController::login", null, false);
$rotas->add("GET", "/clientes/lista", "ClienteController::listarClientes", null, true);
$rotas->add("GET", "/clientes/buscar", "ClienteController::buscarPorId", array("id"), true);
$rotas->add("POST", "/clientes/salvar", "ClienteController::salvarCliente", null, true);
$rotas->add("PUT", "/clientes/editar/{param}", "ClienteController::atualizarCliente", null, true);
$rotas->add("DELETE", "/clientes/excluir/{param}", "ClienteController::excluirCliente", null, true);

$rotas->irParaRota($_GET['path']);

