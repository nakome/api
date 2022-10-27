<?php

declare (strict_types = 1);

namespace App\Controllers\Create;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Create\CreateModel as CreateModel;
use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Create controller
 *
 * [url]api/create/[dbname]
 */
class CreateController
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
        // inicialize auth
        $auth = new Auth();
        if ($auth->check()) {
            // inicialize CreateModel
            $CreateModel = new CreateModel();
            $output = $CreateModel->data($dbname);
            // if ouput
            if ($output) {
                $msg = "Success, the table {$dbname} has been created!";
                Utils::log("Create {$dbname}", (string)$msg);
                MessageView::setMsg($msg);
            } else {
                $msg = "Error, the table {$dbname} has not created!";
                Utils::log("Delete data {$dbname}", (string)$msg);
                MessageView::setMsg($msg, '400');
            }

        }
    }
}
