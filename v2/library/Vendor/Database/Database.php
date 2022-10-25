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
defined('ACCESS') or exit(ACCESSINFO);

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
        $pdo = null;
        if (in_array(constant('DB_TYPE'), PDO::getAvailableDrivers())) {
            try {
                $name = constant('DB_FILE');
                $user = constant('DB_USER');
                $pass = constant('DB_PASS');
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
}
