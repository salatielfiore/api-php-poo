<?php

/**
 * Classe utilitária para manipulação de strings.
 * @author Salatiel Fiore
 */
class StringUtils
{

    /**
     * Remove a máscara de formatação de um número de telefone.
     *
     * @param string $telefone Número de telefone com máscara.
     * @return string Número de telefone sem máscara.
     */
    public static function removeMascaraTelefone($telefone)
    {
        return preg_replace('/[^0-9]/', '', $telefone);
    }

}