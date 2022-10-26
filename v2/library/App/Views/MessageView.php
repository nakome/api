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
     * Default array output
     *
     * @return array
     */
    private static function __defaultArray(): array
    {
        return [
            'STATUS' => 200,
            'IP' => Url::getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
            'MESSAGE' => '',
            'PARAMS' => $_GET,
            'DATA' => $_POST,
        ];
    }

    /**
     * Set message
     *
     * @param string $message
     * @return void
     */
    public static function setMsg(string $message, string $status = "200")
    {
        @header('Content-type: application/json');
        $arr = self::__defaultArray();
        $arr['STATUS'] = $status;
        $arr['MESSAGE'] = $message;
        exit(json_encode($arr));
    }
}
