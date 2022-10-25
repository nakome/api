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
trait Database
{
    /**
     * Connect Database.
     *
     * @return object
     */
    public function dbConnect(): object
    {
        $pdo = null;
        if (in_array($this->config['dbType'], PDO::getAvailableDrivers())) {
            try {
                $name = $this->config['dbFile'];
                $user = $this->config['dbUser'];
                $pass = $this->config['dbPass'];
                $pdo = new PDO("sqlite:$name", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_PERSISTENT, PDO::ERRMODE_SILENT);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException$e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        } else {
            throw new DatabaseDriverFailure("Database does not exist");
        }
        return $pdo;
    }

    /**
     * Show error msg
     *
     * @param string $message
     * @return array
     */
    public function showErrorMessage(
        string $message
    ) {
        return $this->displayJsonView([
            'STATUS' => 404,
            'IP' => $this->getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'],
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
            'MESSAGE' => $message,
            'PARAMS' => $_GET,
            'DATA' => $_POST,
        ]);
    }

    /**
     * Check table if not exists
     *
     * @param object $pdo
     * @param string $dbname
     * 
     * @return void
     */
    public function checkTableNotExists(
        object $pdo,
        string $dbname
    ):void {
        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name='{$dbname}'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $output = $stmt->fetchAll();
        if (!$output) {
            $this->showErrorMessage(
                $this->format(
                    $this->__languages["tableNotExists"], [$dbname]
                )
            );
            exit();
        }
    }
}
