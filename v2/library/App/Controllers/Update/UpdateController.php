<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers\Update;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Get\GetUidModel as GetUidModel;
use App\Models\Update\UpdateModel as UpdateModel;
use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Update controller
 *
 * [url]api/insert/[dbname]
 */
class UpdateController
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
            $_POST = json_decode(file_get_contents('php://input'), true);

            // get params
            $uid = (isset($_GET['uid'])) ? urldecode($_GET['uid']) : false;

            // check params
            if ($uid && is_array($_POST)) {

                // init model
                $GetUidModel = new GetUidModel();
                $row = $GetUidModel->data($dbname, $uid);

                // output
                if ($row) {
                    // data
                    $data = [
                        'uid' => $uid,
                        'name' => $row['name'],
                        'author' => isset($_POST['author']) ? $_POST['author'] : $row['author'],
                        'author_info' => isset($_POST['author_info']) ? $_POST['author_info'] : $row['author_info'],
                        'title' => isset($_POST['title']) ? $_POST['title'] : $row['title'],
                        'description' => isset($_POST['description']) ? $_POST['description'] : $row['description'],
                        'category' => isset($_POST['category']) ? $_POST['category'] : $row['category'],
                        'public' => isset($_POST['public']) ? $_POST['public'] : $row['public'],
                        'token' => bin2hex(openssl_random_pseudo_bytes(16)),
                        'content' => isset($_POST['content']) ? $_POST['content'] : $row['content'],
                        'created' => $row['created'],
                        'updated' => date("Y-m-d H:i:s"),
                    ];
                    // init model
                    $UpdateModel = new UpdateModel();
                    $result = $UpdateModel->data($dbname, $data, $uid);

                    // output
                    if ($result) {
                        $msg = "Success, the data on {$dbname} has been updated!";
                        Utils::log("Post data {$dbname}", (string)$msg);
                        MessageView::setMsg($msg);
                    } else {
                        $msg = "Error, the data on {$dbname} has not updated!";
                        Utils::log("Post data {$dbname}", (string)$msg);
                        MessageView::setMsg($msg);
                    }
                } else {
                    $msg = "Error, the data on {$dbname} has not updated!";
                    Utils::log("Post data {$dbname}", (string)$msg);
                    MessageView::setMsg($msg);
                }
            }
        }
    }
}
