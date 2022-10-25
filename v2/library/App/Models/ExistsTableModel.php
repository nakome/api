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
class ExistsTableModel
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
     * @return array
     */
    public function data(
        string $dbname
    ): array {

        $this->getConnection();

        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name='{$dbname}'";
        $stmt = $this->__database->prepare($query);
        $stmt->execute();
        $output = $stmt->fetchAll();
        return $output;
    }
}
