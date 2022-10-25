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

use App\Models\GetNameModel as GetNameModel;
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
                    Utils::log("Get name {$dbname}", (string) "Success get name");
                    ResponseView::json(
                        ResponseView::single($output)
                    );
                } else {
                    Utils::log("Get name {$dbname}", (string) "Error get name");
                    MessageView::setError(
                        "Error to obtain data from {$dbname}"
                    );
                }
            } catch (Exception $e) {
                MessageView::setError($e->getMessage());
            }
        }
    }
}
