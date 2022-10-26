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

use App\Models\Get\GetUpdatedModel as GetUpdatedModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get updated data
 *
 * [url]api/get/[dbname]/?updated=1
 * [url]api/get/[dbname]/?updated=1&limit=2
 * [url]api/get/[dbname]/?updated=1&limit=2&offset=2
 */
class GetUpdatedController
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

        // init auth
        $auth = new Auth();

        // check auth
        if ($auth->check() and array_key_exists('updated', $_GET)) {
            try {

                // get params
                $updated = (string)trim(urldecode($_GET["updated"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // init model
                $GetUpdatedModel = new GetUpdatedModel();
                $output = $GetUpdatedModel->data($dbname, $updated, $limit, $offset);

                // output
                if ($output) {
                    $msg = "Success, to obtain data from {$dbname}";
                    Utils::log("Get updated {$dbname}", (string)$msg);
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get updated {$dbname}", (string)$msg);
                    MessageView::setMsg($msg);
                }

            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage());
            }
        }
    }
}
