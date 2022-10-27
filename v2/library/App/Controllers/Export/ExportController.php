<?php

declare (strict_types = 1);

namespace App\Controllers\Export;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Export\ExportModel as ExportModel;
use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Utils\Utils as Utils;

/**
 * Export controller
 */
class ExportController
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
        // [url]api/insert/[dbname]
        if ($auth->check()) {
            try {
                $ExportModel = new ExportModel();
                $output = $ExportModel->data($dbname);
                $msg = "Success, table {$dbname} has been exported!";
                Utils::log("Export {$dbname}", (string)$msg);
            } catch (Exception $e) {
                MessageView::setMsg($e->getMessage(), '400');
            }
        }
    }
}
