<?php

class response
{
    static function responseData($status, $message, $data)
    {
        return array(
            "status" => $status,
            "message" => $message,
            "data" => $data
        );
    }

    static function responseError($status, $message, $error)
    {
        header("HTTP/1.1 $status $error");
        return array(
            "status" => $status,
            "message" => $message,
            "error" => $error
        );
    }
}