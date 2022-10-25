<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\DropModel as DropModel;
use App\Models\ExistsTableModel as ExistsTableModel;
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
                    Utils::log("Drop {$dbname}", (string) "Success drop table");
                    ResponseView::json([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => "Success, the table {$dbname} has been deleted!",
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    Utils::log("Drop {$dbname}", (string) "Error delete table");
                    ResponseView::json([
                        'STATUS' => 404,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => "Error, the table {$dbname} has not deleted!",
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                }

            } else {
                Utils::log("Post data {$dbname}", (string) "Error export data");
                ResponseView::json([
                    'MESSAGE' => "Error, table {$dbname} not exists!",
                ]);
            }
        }
    }
}
