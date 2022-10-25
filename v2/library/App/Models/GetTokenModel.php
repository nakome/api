<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class GetTokenModel
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
     * Get all public data
     *
     * @param string $dbname
     * @param string $token
     * @return void
     */
    public function data(
        string $dbname,
        string $token
    ) {

        $this->getConnection();

        $query = "SELECT * FROM {$dbname} WHERE token=:token";
        $stmt = $this->__database->prepare($query);
        $stmt->execute([':token' => $token]);

        return $stmt->fetch();
    }
}
