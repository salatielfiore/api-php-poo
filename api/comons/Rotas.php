<?php

class Rotas
{

    private $listaRotas = array();
    private $listaCallback = array();
    private $listaProtecao = array();
    private $listaparametros = array();

    public function add($metodo, $rota, $callback, $parametros, $protecao)
    {
        $this->listaRotas[] = "$metodo:$rota";
        $this->listaCallback[] = $callback;
        $this->listaparametros[] = $parametros;
        $this->listaProtecao[] = $protecao;
    }

    public function ir($rota)
    {
        $parametros = array();
        $protecao = '';
        $methodServer = $_SERVER['REQUEST_METHOD'];
        $rota = $methodServer . ":/" . $rota;

        if (substr_count($rota, "/") >= 3) {
            $parametros["pathVariable"] = substr($rota, strrpos($rota, "/") + 1);
            $rota = substr($rota, 0, strrpos($rota, "/")) . "/{param}";
        }

        $indice = array_search($rota, $this->listaRotas);
        if ($indice === false) {
            ErroMessageResponse::notFoundErro('error_not_found');
            exit();
        }
        $params = $this->listaparametros[$indice];
        $callback = explode("::", $this->listaCallback[$indice]);
        $protecao = $this->listaProtecao[$indice];
        if (isset($params)) {
            foreach ($params as $paramentro) {
                if (!isset($_GET[$paramentro])) {
                    ErroMessageResponse::notFoundErro('error_not_found');
                    exit();
                }
                $parametros[$paramentro] = $_GET[$paramentro];
            }
        }

        $class = $callback[0];
        $method = $callback[1];

        if (class_exists($class)) {
            if ($protecao) {
                $usuarioService = new UsuarioService();
                $usuarioService->validarJWT();
            }
            if (method_exists($class, $method)) {
                $intanciaClass = new $class();
                call_user_func_array(
                    array($intanciaClass, $method),
                    array($parametros)
                );
            }
        }
    }
}