<?php

declare (strict_types = 1);

namespace App\Controllers\Get;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetNameModel as GetNameModel;
use App\Views\MessageView as MessageView;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Get name data
 *
 * [url]api/get/[dbname]/?name=name
 */
class GetNameController
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
        if ($auth->check() and array_key_exists('name', $_GET)) {
            try {

                // get params
                $name = (string)trim($_GET["name"]);

                // init model
                $GetNameModel = new GetNameModel();
                $output = $GetNameModel->data($dbname, $name);

                // if output
                if ($output) {
                    $msg = "Success, to obtain data from {$dbname}";
                    Utils::log("Get name {$dbname}", (string)$msg);
                    ResponseView::json(
                        ResponseView::single($output)
                    );
                } else {
                    $msg = "Error to obtain data from {$dbname}";
                    Utils::log("Get name {$dbname}", (string)$msg);
                    MessageView::setMsg($msg, '400');
                }
            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage(), '400');
            }
        }
    }
}
