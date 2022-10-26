<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace Vendor\Database;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit('Sorry, you dont have access file.');

use PDO;

/**
 * Database
 */
class Database
{

    /**
     * Connect Database.
     *
     * @return object
     */
    public function connect(): object
    {

        $dbtype = constant('DB_TYPE');
        $host = constant('DB_HOST');
        $db = constant('DB_NAME');
        $user = constant('DB_USER');
        $pass = constant('DB_PASS');
        $charset = constant('DB_CHARSET');
        $sqliteName = constant('DB_FILE');
        $mysql = "mysql:host=$host;dbname=$db;charset=$charset";
        $sqlite = "$dbtype:$sqliteName";
        
        $pdo = null;
        if ($dbtype == 'sqlite') {
            if (in_array(constant('DB_TYPE'), PDO::getAvailableDrivers())) {
                try {
                    $pdo = new PDO($sqlite, $user, $pass);
                    $pdo->setAttribute(PDO::ATTR_PERSISTENT, PDO::ERRMODE_SILENT);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (\PDOException$e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                }
            } else {
                throw new DatabaseDriverFailure("Database does not exist");
            }
        } else {
            try {
                $pdo = new PDO($mysql, $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException$e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return $pdo;
    }
}
