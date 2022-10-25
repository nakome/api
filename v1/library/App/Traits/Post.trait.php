<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

/*
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2020 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
trait Post
{
    /**
     * POST routes.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function postData(string $dbname): void
    {
        if ($this->auth() && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            if (is_array($_POST)) {
                //generate random string
                $rand_token = openssl_random_pseudo_bytes(16);
                //change binary to hexadecimal
                $token = bin2hex($rand_token);
                // random uid
                $randomUid = $this->randomUid("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 6);
                // data
                $data = [
                    'name' => $randomUid,
                    'author' => isset($_POST['author']) ? $_POST['author'] : 'Anonymous',
                    'author_info' => isset($_POST['author_info']) ? $_POST['author_info'] : 'Not info provide',
                    'title' => isset($_POST['title']) ? $_POST['title'] : 'default title',
                    'description' => isset($_POST['description']) ? $_POST['description'] : 'default description',
                    'category' => isset($_POST['category']) ? $_POST['category'] : 'default',
                    'public' => isset($_POST['public']) ? $_POST['public'] : (string) 0,
                    'token' => $token,
                    'content' => isset($_POST['content']) ? $_POST['content'] : '[]',
                ];
                $sql = "INSERT INTO {$dbname} (name,author,author_info,title,description,category, public, token,content) VALUES (:name,:author,:author_info,:title,:description,:category,:public,:token,:content)";
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute($data)) {
                    $this->log("Post data {$dbname}",(string) "Success post data");
                    $this->displayJsonView([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => $this->getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $this->format(
                            $this->__languages['successCreateRow'], [$dbname]
                        ),
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    $this->log("Post data {$dbname}",(string) "Error post data");
                    $this->displayJsonView([
                        'STATUS' => 404,
                        'IP' => $this->getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $this->format(
                            $this->__languages['errorCreateRow'], [$dbname]
                        ),
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                }
            }
        }

        $this->createApiResponse();
    }
}
