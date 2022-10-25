<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\GetUidModel as GetUidModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get uid data
 * 
 * [url]api/get/[dbname]/?uid=1
 */
class GetUidController
{
    public static function data(
        string $dbname
    ): void {
        // init auth
        $auth = new Auth();

        // check auth
        if ($auth->check() and array_key_exists('uid', $_GET)) {
            try {

                // get params
                $uid = (string)trim($_GET["uid"]);

                // init model
                $GetUidModel = new GetUidModel();
                $output = $GetUidModel->data($dbname, $uid);

                // output
                if ($output) {
                    Utils::log("Get uid {$dbname}", (string) "Success get uid");
                    ResponseView::json(
                        ResponseView::single($output)
                    );
                } else {
                    Utils::log("Get uid {$dbname}", (string) "Error get uid");
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
