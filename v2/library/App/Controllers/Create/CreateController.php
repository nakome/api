<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers\Create;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Create\CreateModel as CreateModel;
use App\Views\ResponseView as ResponseView;
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
                $msg = "Error, the table {$dbname} has not created!";
                Utils::log("Delete data {$dbname}", (string)$msg);
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

        }
    }
}
