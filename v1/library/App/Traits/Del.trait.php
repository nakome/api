<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

use PDO;

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
trait Del
{
    /**
     * DEL routes.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function delData(string $dbname): void
    {
        if ($this->auth() && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            if (is_array($_POST)) {
                // uid params
                $uid = (isset($_POST['uid'])) ? urldecode($_POST['uid']) : false;
                $token = (isset($_POST['token'])) ? urldecode($_POST['token']) : false;
                $sql = "DELETE FROM {$dbname} WHERE uid=:uid AND token=:token";
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo,$dbname);
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':uid', $uid, PDO::PARAM_INT);
                $statement->bindParam(':token', $token, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $this->log("Delete row {$dbname}",(string) "Success delete row ");
                    $this->displayJsonView([
                        'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                        'IP' => $this->getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $this->format($this->__languages['successDeleteRow'], [$uid]),
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                } else {
                    $this->log("Delete row {$dbname}",(string) "Error delete row ");
                    $this->displayJsonView([
                        'STATUS' => 404,
                        'IP' => $this->getIp(),
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'MESSAGE' => $this->format($this->__languages['errorDeleteRow'], [$uid]),
                        'PARAMS' => $_GET,
                        'DATA' => $_POST,
                    ]);
                }
            }
        }

        $this->createApiResponse();
    }

    /**
     * Create table.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function destroy(string $dbname): void
    {
        if ($this->auth()) {
            // connect database
            $pdo = $this->dbConnect();
            // if table not exists show message
            $this->checkTableNotExists($pdo,$dbname);
            $sql = "DROP TABLE {$dbname}";
            $output = $pdo->query($sql);
            if ($output) {
                $this->log("Destroy {$dbname}",(string) "Success destroy");
                $this->createApiResponse([
                    'MESSAGE' => $this->format(
                        $this->__languages['successDeleteTable'], [$dbname]
                    ),
                ]);
            } else {
                $this->log("Destroy {$dbname}",(string) "Error destroy");
                $this->createApiResponse([
                    'MESSAGE' => $this->format(
                        $this->__languages['errorDeleteTable'], [$dbname]
                    ),
                ]);
            }
        }

        $this->createApiResponse();
    }
}
