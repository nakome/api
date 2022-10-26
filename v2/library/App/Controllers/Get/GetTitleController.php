<?php

declare (strict_types = 1);

namespace App\Controllers\Get;

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
                    $msg = "Success, to obtain data from {$dbname}";
                    Utils::log("Get title {$dbname}", (string) $msg);
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get title {$dbname}", (string) $msg);
                    MessageView::setMsg($msg);
                }

            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage());
            }
        }
    }
}
