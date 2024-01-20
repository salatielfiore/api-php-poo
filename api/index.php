<?php
require_once "comons/HttpStatus.php";
include_once "comons/Response.php";
include_once "comons/ErroMessageResponse.php";

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

$messages = include 'comons/messages.php';

if (isset($_GET['path'])) {
    $path = explode("/", $_GET['path']);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

} else {
    ErroMessageResponse::notFoundErro('error_not_found');
    exit;
}

if (isset($path[0])) {
    $api = $path[0];
} else {
    ErroMessageResponse::notFoundErro('error_not_found');
    exit;
}
if (isset($path[1])) {
    $acao = $path[1];
} else {
    $acao = '';
}
if (isset($path[2])) {
    $param = $path[2];
} else {
    $param = '';
}

$GLOBALS['secretJWT'] = '123456';

$method = $_SERVER['REQUEST_METHOD'];

include_once "controller/ClienteController.php";
include_once "controller/LoginController.php";

