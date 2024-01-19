<?php

/**
 * Classe utilitária para manipulação de dados JSON.
 * @author Salatiel Fiore
 */
class JsonUtils
{
    /**
     * Obtém e decodifica os dados JSON do corpo de uma requisição POST.
     *
     * @return array|null Array associativo contendo os dados decodificados do JSON.
     */
    public static function pegarDadosPostJson()
    {
        // Obtém o conteúdo JSON do corpo da solicitação
        $json_data = file_get_contents("php://input");
        // Decodifica o JSON em um array associativo
        return json_decode($json_data, true);
    }

    /**
     * Valida se os campos necessários estão presentes nos dados fornecidos.
     *
     * @param array $data Dados a serem validados.
     * @param array $campos Lista de campos obrigatórios.
     * @return void
     */
    public static function validarDadosPostCliente($data, array $campos)
    {
        // Verifica se o número de campos obrigatórios é maior que o número total de campos nos dados
        if (count($campos) > count($data)) {
            ErroMessageResponse::badRequestErro('error_response_json');
            exit();
        }

        // Verifica se cada campo obrigatório está presente nos dados
        foreach ($campos as $campo) {
            if (!isset($data[$campo])) {
                ErroMessageResponse::badRequestErro('error_response_json');
                exit();
            }
        }
    }

}