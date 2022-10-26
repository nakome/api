<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers\Delete;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Create\ExistsTableModel as ExistsTableModel;
use App\Models\Delete\DropModel as DropModel;
use App\Views\ResponseView as ResponseView;
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

            // Check if exists table
            $ExistsTableModel = new ExistsTableModel();
            if ($ExistsTableModel->data($dbname)) {
                // init DropModel
                $DropModel = new DropModel();
                $output = $DropModel->data($dbname);
                // if output
                if ($output) {
                    $msg = "Success, the table {$dbname} has been deleted!";
                    Utils::log("Drop {$dbname}", (string)$msg);
                    ResponseView::json([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $msg,
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    $msg = "Error, the table {$dbname} has not deleted!";
                    Utils::log("Drop {$dbname}", (string)$msg);
                    ResponseView::json([
                        'STATUS' => 404,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $msg,
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                }

            } else {
                Utils::log("Post data {$dbname}", (string) "Error, table {$dbname} not exists!");
                ResponseView::json([
                    'MESSAGE' => "Error, table {$dbname} not exists!",
                ]);
            }
        }
    }
}