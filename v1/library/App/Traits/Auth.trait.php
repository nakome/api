<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

/*
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2020 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
trait Auth
{
    /**
     *  Basic auth.
     *
     * @return bool
     */
    public function auth(): bool
    {
        if ($this->getBearerToken() === $this->config['token']) {
            return true;
        }
        return false;
    }

    /**
     * Get header Authorization.
     *
     * @return mixed
     */
    public function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER['Authorization']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            //Nginx or fast CGI
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header.
     *
     * @return mixed
     */
    public function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
