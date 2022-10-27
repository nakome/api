<?php

declare (strict_types = 1);

namespace App\Controllers\Delete;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Delete\DropModel as DropModel;
use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Drop controller
 * [url]api/v2/drop/[dbname]
 */
class DropController
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
        if ($auth->check()) {
            // init DropModel
            $DropModel = new DropModel();
            $output = $DropModel->data($dbname);
            // if output
            if ($output) {
                $msg = "Success, the table {$dbname} has been deleted!";
                Utils::log("Drop {$dbname}", (string)$msg);
                MessageView::setMsg($msg);
            } else {
                $msg = "Error, the table {$dbname} has not deleted!";
                Utils::log("Drop {$dbname}", (string)$msg);
                MessageView::setMsg($msg, '400');
            }
        }
    }
}
