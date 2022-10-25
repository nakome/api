<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

/**
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2020 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
trait Url
{
    /**
     * C.O.R.S.
     */
    public static function cors()
    {
        // Permitir que desde cualquier origen
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide el origen $_SERVER['HTTP_ORIGIN']
            // que quieres permitir, y si es así:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache de 1 dia
        }
        // Los encabezados de Control de Acceso se reciben durante las solicitudes de OPCIONES
        if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header('Access-Control-Allow-Methods: GET,POST, OPTIONS');
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit(0);
        }
    }

    /**
     * Check if is localhost
     *
     * @return bool
     */
    public static function isLocalhost()
    {
        if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            return true;
        }
        return false;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public static function siteUrl(): string
    {
        // check if is https or http
        if(!self::run()->config['url']) {
            $https = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
            $defaultUrl = $https . rtrim(rtrim($_SERVER['HTTP_HOST'], '\\/') . dirname($_SERVER['PHP_SELF']), '\\/');
            if (self::isLocalhost()) {
                $port = $_SERVER['REMOTE_PORT'];
                if (preg_match("/8080/s", $port)) {
                    return 'http://' . $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT'];
                } else {
                    return $defaultUrl;
                }
            } else {
                return $defaultUrl;
            }
        }else{
            return self::run()->config['url'];
        }
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Create slug
     *
     * @param string
     *
     * @return string
     */
    public static function createSlug(
        string $str,
        string $delimiter = '-'
    ): string {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}
