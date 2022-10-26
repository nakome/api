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
class GetAuthorModel
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
     * Get data
     *
     * @param string $dbname
     * @param string $author
     * @param string $limit
     * @param string $offset
     * @return void
     */
    public function data(
        string $dbname,
        string $author,
        string $limit,
        string $offset
    ) {

        $this->getConnection();

        $query = "SELECT * FROM {$dbname} WHERE author LIKE '%{$author}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->__database->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
