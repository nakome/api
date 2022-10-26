<?php

declare (strict_types = 1);

namespace App\Controllers\Get;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetCreatedModel as GetCreatedModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get created data
 *
 * [url]api/get/[dbname]/?created=name
 * [url]api/get/[dbname]/?created=adfasdf&limit=2
 * [url]api/get/[dbname]/?created=adsfads&limit=2&offset=2
 */
class GetCreatedController
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
        if ($auth->check() and array_key_exists('created', $_GET)) {
            try {

                // get params
                $created = (string)trim(urldecode($_GET["created"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // new model
                $GetCreatedModel = new GetCreatedModel();
                $output = $GetCreatedModel->data($dbname, $created, $limit, $offset);
                if ($output) {
                    $msg = "Success, to obtain data from {$dbname}";
                    Utils::log("Get created {$dbname}", (string)$msg);
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get created {$dbname}", (string)$msg);
                    MessageView::setMsg($msg);
                }

            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage());
            }
        }
    }
}
