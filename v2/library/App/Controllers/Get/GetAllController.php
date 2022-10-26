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

use App\Models\Get\GetAllModel as GetAllModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get all data
 *
 * [url]api/get/[dbname]/?all=1
 * [url]api/get/[dbname]/?all=1&limit=2
 * [url]api/get/[dbname]/?all=1&limit=2&offset=2
 */
class GetAllController
{
    /**
     * Static method to get data
     *
     * @param string $dbname
     * @return void
     */
    public static function data(
        string $dbname
    ): void {
        $auth = new Auth();
        if ($auth->check() and array_key_exists('all', $_GET)) {
            try {
                // get params
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // new model
                $GetAllModel = new GetAllModel();
                $output = $GetAllModel->data($dbname, $limit, $offset);

                // if output
                if ($output) {
                    $msg = "Success to obtain data from {$dbname}";
                    Utils::log("Get all {$dbname}", (string)$msg);
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get all {$dbname}", (string)$msg);
                    MessageView::setError($msg);
                }

            } catch (Exception $e) {
                MessageView::setError($e->getMessage());
            }
        }
    }
}
