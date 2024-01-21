<?php

/**
 * Classe HttpStatus para definir códigos e valores comuns de status HTTP.
 */
class HttpStatus
{
    const OK_STATUS = 200;
    const BAD_REQUEST_VALUE = "Bad Request";
    const BAD_REQUEST_STATUS = 400;
    const UNAUTHORIZED_VALUE = "Unauthorized";
    const UNAUTHORIZED_STATUS = 401;
    const FORBIDDEN_VALUE = "Forbidden";
    const FORBIDDEN_STATUS = 403;
    const NOT_FOUND_VALUE = "Not Found";
    const NOT_FOUND_STATUS = 404;
    const INTERNAL_SERVER_ERROR_VALUE = "Internal Server Error";
    const INTERNAL_SERVER_ERROR_STATUS = 500;
}