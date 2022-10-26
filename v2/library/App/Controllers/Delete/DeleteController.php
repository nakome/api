<?php

declare (strict_types = 1);

namespace App\Controllers\Delete;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Delete\DeleteModel as DeleteModel;
use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Update controller
 *
 * [url]api/delete/[dbname]
 */
class DeleteController
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

        if ($auth->check() && $_SERVER['REQUEST_METHOD'] == 'POST') {
            // get post json params
            $_POST = json_decode(file_get_contents('php://input'), true);

            // post params
            $uid = (isset($_POST['uid'])) ? urldecode($_POST['uid']) : false;
            $token = (isset($_POST['token'])) ? urldecode($_POST['token']) : false;

            // check params
            if (is_array($_POST)) {

                // init DeleteModel
                $DeleteModel = new DeleteModel();
                $output = $DeleteModel->data($dbname, $uid, $token);

                // if output
                if ($output) {
                    $msg = "Success, the data on {$dbname} has been deleted!";
                    Utils::log("Delete data {$dbname}", (string)$msg);
                    MessageView::setMsg($msg);
                } else {
                    $msg = "Error, the data on {$dbname} has not deleted!";
                    Utils::log("Delete data {$dbname}", (string)$msg);
                    MessageView::setMsg($msg);
                }
            }
        }
    }
}
