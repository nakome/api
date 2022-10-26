<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models\Get;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class GetNameModel
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
     * @param string $name
     * @return void
     */
    public function data(
        string $dbname,
        string $name
    ) {

        $this->getConnection();

        $sql = "SELECT * FROM {$dbname} WHERE name=:name";
        $stmt = $this->__database->prepare($sql);
        $stmt->execute([':name' => $name]);
        return $stmt->fetch();
    }
}