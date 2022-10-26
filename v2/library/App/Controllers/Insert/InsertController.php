<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers\Insert;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Insert\InsertModel as InsertModel;
use App\Views\ResponseView as ResponseView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Insert controller
 *
 * [url]api/insert/[dbname]
 */
class InsertController
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
        if ($auth->check() && $_SERVER['REQUEST_METHOD'] == 'POST') {
            // json post params
            $_POST = json_decode(file_get_contents('php://input'), true);
            // is array
            if (is_array($_POST)) {

                // data
                $data = [
                    'name' => Utils::randomUid("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 6),
                    'author' => isset($_POST['author']) ? $_POST['author'] : 'Anonymous',
                    'author_info' => isset($_POST['author_info']) ? $_POST['author_info'] : 'Not info provide',
                    'title' => isset($_POST['title']) ? $_POST['title'] : 'default title',
                    'description' => isset($_POST['description']) ? $_POST['description'] : 'default description',
                    'category' => isset($_POST['category']) ? $_POST['category'] : 'default',
                    'public' => isset($_POST['public']) ? $_POST['public'] : (string) 0,
                    'token' => bin2hex(openssl_random_pseudo_bytes(16)),
                    'content' => isset($_POST['content']) ? $_POST['content'] : '[]',
                ];

                // init model
                $InsertModel = new InsertModel();
                $result = $InsertModel->data($dbname, $data);

                // output
                if ($result) {
                    Utils::log("Post data {$dbname}", (string) "Success post data");
                    ResponseView::json([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => Url::getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => "Success, the data on {$dbname} has been saved!",
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    Utils::log("Post data {$dbname}", (string) "Error post data");
                    ResponseView::json([
                        'MESSAGE' => "Error, the data on {$dbname} has not saved!",
                    ]);
                }
            }
        }
    }
}
