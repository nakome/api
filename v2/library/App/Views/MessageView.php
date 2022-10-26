<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Views;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Url\Url as Url;

/**
 * Message view
 */
class MessageView
{
    /**
     * Set message
     *
     * @param string $message
     * @return void
     */
    public static function setMsg(string $message)
    {
        @header('Content-type: application/json');
        $arr = [
            'STATUS' => 200,
            'IP' => Url::getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
            'MESSAGE' => $message,
            'PARAMS' => $_GET,
            'DATA' => $_POST,
        ];
        exit(json_encode($arr));
    }

    /**
     * Set Error message
     *
     * @param string $message
     * @return void
     */
    public static function setError(string $message)
    {
        @header('Content-type: application/json');
        $arr = [
            'STATUS' => 404,
            'IP' => Url::getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
            'MESSAGE' => $message,
            'PARAMS' => $_GET,
            'DATA' => $_POST,
        ];
        exit(json_encode($arr));
    }
}
