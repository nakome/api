<?php

declare (strict_types = 1);

namespace App\Controllers\Insert;

defined('ACCESS') or exit(ACCESSINFO);

use App\Models\Insert\ExistsTitleModel as ExistsTitleModel;
use App\Models\Insert\InsertModel as InsertModel;
use App\Views\MessageView as MessageView;
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

                // check if exists
                $ExistsTitleModel = new ExistsTitleModel();
                $checkIfTitleExists = $ExistsTitleModel->checkIfExists($dbname, $data['title']);
                if (!$checkIfTitleExists) {
                    // init model
                    $InsertModel = new InsertModel();
                    $result = $InsertModel->data($dbname, $data);
                    // output
                    if ($result) {
                        $msg = "Success, the data on {$dbname} has been saved!";
                        Utils::log("Post data {$dbname}", (string)$msg);
                        MessageView::setMsg($msg);
                    } else {
                        $msg = "Error, the data on {$dbname} has not saved!";
                        Utils::log("Post data {$dbname}", (string)$msg);
                        MessageView::setMsg($msg);
                    }
                } else {
                    $msg = "Error, the title on {$dbname} already exists!";
                    Utils::log("Post data {$dbname}", (string)$msg);
                    MessageView::setMsg($msg,'400');
                }
            }
        }
    }
}
