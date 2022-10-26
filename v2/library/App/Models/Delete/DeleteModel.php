<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models\Delete;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use PDO;
use Vendor\Database\Database as Database;

/**
 * Models
 */
class DeleteModel
{
    private $__database;

    /**
     * Connect Database
     *
     * @return void
     */
    public function getConnection()
    {
        $dbObj = new Database();
        $this->__database = $dbObj->connect();
    }

    /**
     * data
     *
     * @param string $dbname
     * @param string $uid
     * @param string $token
     * @return boolean
     */
    public function data(
        string $dbname,
        string $uid,
        string $token
    ): bool {

        $this->getConnection();

        $sql = "DELETE FROM {$dbname} WHERE uid=:uid AND token=:token";
        $stmt = $this->__database->prepare($sql);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
