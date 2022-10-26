<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers\Get;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetTokenModel as GetTokenModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get token data
 * 
 * [url]api/get/[dbname]/?token=1
 */
class GetTokenController
{
    /**
     * Get data
     *
     * @param string $dbname
     * @return void
     */
    public static function data(
        string $dbname
    ): void {
        // init auth
        $auth = new Auth();
        // check auth
        if ($auth->check() and array_key_exists('token', $_GET)) {
            try {
                // get params
                $token = (string)trim($_GET["token"]);
                // init model
                $GetTokenModel = new GetTokenModel();
                $output = $GetTokenModel->data($dbname, $token);
                // output?
                if ($output) {
                    Utils::log("Get token {$dbname}", (string) "Success get token");
                    ResponseView::json(
                        ResponseView::single($output)
                    );
                } else {
                    Utils::log("Get token {$dbname}", (string) "Error get token");
                    MessageView::setError(
                        "Error to obtain data from {$dbname}"
                    );
                }
            } catch (Exception $e) {
                MessageView::setError($e->getMessage());
            }
        }
    }
}