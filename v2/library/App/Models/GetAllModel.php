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
class GetAllModel
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
     * @param string $limit
     * @param string $offset
     * @return void
     */
    public function data(
        string $dbname,
        string $limit,
        string $offset
    ) {

        $this->getConnection();

        $query = "SELECT * FROM {$dbname} ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->__database->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
