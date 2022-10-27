<?php

declare (strict_types = 1);

namespace App\Controllers\Get;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetCategoryModel as GetCategoryModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get category data
 *
 * [url]api/get/[dbname]/?category=name
 * [url]api/get/[dbname]/?category=adfasdf&limit=2
 * [url]api/get/[dbname]/?category=adsfads&limit=2&offset=2
 */
class GetCategoryController
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
        if ($auth->check() and array_key_exists('category', $_GET)) {
            try {
                // get params
                $category = (string)trim(urldecode($_GET["category"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // new model
                $GetCategoryModel = new GetCategoryModel();
                $output = $GetCategoryModel->data($dbname, $category, $limit, $offset);
                if ($output) {
                    $msg = "Success, to obtain data from {$dbname}";
                    Utils::log("Get category {$dbname}", (string)$msg);
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get category {$dbname}", (string)$msg);
                    MessageView::setMsg($msg, '400');
                }

            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage(), '400');
            }
        }
    }
}
