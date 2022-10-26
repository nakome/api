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

use App\Models\Get\GetUidModel as GetUidModel;
use App\Models\Delete\DeleteModel as DeleteModel;
use App\Views\ResponseView as ResponseView;
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
                $output = $DeleteModel->data($dbname, $uid,$token);

                // if output
                if ($output) {
                    Utils::log("Delete data {$dbname}", (string) "Success delete data");
                    ResponseView::json([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => "Success, the data on {$dbname} has been deleted!",
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    Utils::log("Delete data {$dbname}", (string) "Error delete data");
                    ResponseView::json([
                        'STATUS' => 404,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => "Error, the data on {$dbname} has not deleted!",
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                }
            }
        }
    }
}
