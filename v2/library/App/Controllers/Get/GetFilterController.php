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

use App\Models\Get\GetFilterModel as GetFilterModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get public data
 *
 * [url]api/filter/[dbname]/?public=1
 * [url]api/filter/[dbname]/?public=1&limit=2
 * [url]api/filter/[dbname]/?public=1&limit=2&offset=2
 */
class GetFilterController
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
        if ($auth->check() and array_key_exists('filter', $_GET)) {
            try {

                // get params
                $filter = (string)urldecode($_GET["filter"]);
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // check if the filter not contain this words
                if (
                    $filter !== 'content' ||
                    $filter !== 'uid' ||
                    $filter !== 'token' ||
                    $filter !== 'public'
                ) {

                    // init model
                    $GetFilterModel = new GetFilterModel();
                    $output = $GetFilterModel->data($dbname, $filter, $limit, $offset);

                    // output
                    if ($output) {
                        $msg = "Success, to obtain data from {$dbname}";
                        Utils::log("Filter data {$dbname}", (string)$msg);
                        ResponseView::json(
                            ResponseView::filter($filter, $output)
                        );
                    } else {
                        $msg = "Error to filter data from {$dbname}";
                        Utils::log("Filter data {$dbname}", (string)$msg);
                        MessageView::setError($msg);
                    }
                }

            } catch (Exception $e) {
                MessageView::setError($e->getMessage());
            }
        }
    }
}
