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

use App\Models\Get\GetTitleModel as GetTitleModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get title data
 * 
 * [url]api/get/[dbname]/?title=qewr
 * [url]api/get/[dbname]/?title=qewr&limit=2
 * [url]api/get/[dbname]/?title=qewr&limit=2&offset=2
 */
class GetTitleController
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
        // auth
        $auth = new Auth();
        // check auth
        if ($auth->check() and array_key_exists('title', $_GET)) {
            try {

                // get params
                $title = (string)trim(urldecode($_GET["title"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // new model
                $GetTitleModel = new GetTitleModel();
                $output = $GetTitleModel->data($dbname, $title, $limit, $offset);

                // output
                if ($output) {
                    Utils::log("Get title {$dbname}", (string) "Success get title");
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    Utils::log("Get title {$dbname}", (string) "Error on get title");
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
