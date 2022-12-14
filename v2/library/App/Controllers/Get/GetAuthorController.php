<?php

declare (strict_types = 1);

namespace App\Controllers\Get;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetAuthorModel as GetAuthorModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get author data
 *
 * [url]api/get/[dbname]/?author=name
 * [url]api/get/[dbname]/?author=adfasdf&limit=2
 * [url]api/get/[dbname]/?author=adsfads&limit=2&offset=2
 */
class GetAuthorController
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
        if ($auth->check() and array_key_exists('author', $_GET)) {
            try {

                // get params
                $author = (string)trim(urldecode($_GET["author"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : (string) 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : (string) 0;

                // new model
                $GetAuthorModel = new GetAuthorModel();
                $output = $GetAuthorModel->data($dbname, $author, $limit, $offset);
                if ($output) {
                    Utils::log("Get author {$dbname}", (string) "Success get author");
                    ResponseView::json(
                        ResponseView::full($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get author {$dbname}", (string) $msg);
                    MessageView::setMsg($msg, '400');
                }

            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage(), '400');
            }
        }
    }
}
