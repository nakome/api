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
trait Put
{
    /**
     * POST routes.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function putData(string $dbname): void
    {
        if ($this->auth() && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $uid = (isset($_GET['uid'])) ? urldecode($_GET['uid']) : false;
            if ($uid && is_array($_POST)) {
                //generate unique token
                $rand_token = openssl_random_pseudo_bytes(16);
                $token = bin2hex($rand_token);
                // random uid
                $randomUid = $this->randomUid("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 6);
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $stmt = $pdo->prepare("SELECT * FROM {$dbname} WHERE uid=:uid");
                $stmt->execute([':uid' => $uid]);
                $row = $stmt->fetch();
                if ($row) {
                    $data = [
                        'uid' => $uid,
                        'name' => $row['name'],
                        'author' => isset($_POST['author']) ? $_POST['author'] : $row['author'],
                        'author_info' => isset($_POST['author_info']) ? $_POST['author_info'] : $row['author_info'],
                        'title' => isset($_POST['title']) ? $_POST['title'] : $row['title'],
                        'description' => isset($_POST['description']) ? $_POST['description'] : $row['description'],
                        'category' => isset($_POST['category']) ? $_POST['category'] : $row['category'],
                        'public' => isset($_POST['public']) ? $_POST['public'] : $row['public'],
                        'token' => $token,
                        'content' => isset($_POST['content']) ? $_POST['content'] : $row['content'],
                        'created' => $row['created'],
                        'updated' => date("Y-m-d H:i:s"),
                    ];
                    $sql = "UPDATE {$dbname} SET name=:name, author=:author, author_info=:author_info, title=:title, description=:description, category=:category,public=:public,token=:token,content=:content,created=:created,updated=:updated WHERE uid=:uid";
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute($data)) {
                        $this->log("Put data {$dbname}",(string) "Success put data");
                        $this->displayJsonView([
                            'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                            'IP' => $this->getIp(),
                            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                            'MESSAGE' => $this->format(
                                $this->__languages['successUpdateRow'], [$uid]
                            ),
                            'PARAMS' => $_GET,
                            'DATA' => $_POST,
                        ]);
                    } else {
                        $this->log("Put data {$dbname}",(string) "Error put data");
                        $this->displayJsonView([
                            'STATUS' => 404,
                            'IP' => $this->getIp(),
                            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                            'MESSAGE' => $this->format(
                                $this->languages['errorUpdateRow'], [$uid]
                            ),
                            'PARAMS' => $_GET,
                            'DATA' => $_POST,
                        ]);
                    }
                } else {
                    $this->log("Put data {$dbname}",(string) "Error put data");
                    $this->displayJsonView([
                        'STATUS' => 404,
                        'IP' => $this->getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $this->format(
                            $this->__languages['successUpdateRow'], [$uid]
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
