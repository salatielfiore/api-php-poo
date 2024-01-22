<?php

/**
 * Classe responsável por gerenciar as rotas da aplicação.
 * @author Salatiel Fiore
 */
class Rotas
{

    private $listaRotas = array();
    private $listaCallback = array();
    private $listaProtecao = array();
    private $listaparametros = array();

    /**
     * Adiciona uma rota à lista de rotas.
     *
     * @param string $metodo Método HTTP da rota.
     * @param string $rota Caminho da rota.
     * @param string $callback Callback a ser executado quando a rota é acessada.
     * @param array $parametros Parâmetros esperados pela rota.
     * @param bool $protecao Indica se a rota requer autenticação.
     */
    public function add($metodo, $rota, $callback, $parametros, $protecao)
    {
        $this->listaRotas[] = "$metodo:$rota";
        $this->listaCallback[] = $callback;
        $this->listaparametros[] = $parametros;
        $this->listaProtecao[] = $protecao;
    }

    /**
     * Navega para a rota especificada.
     *
     * @param string $rota Rota a ser acessada.
     */
    public function irParaRota($rota)
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