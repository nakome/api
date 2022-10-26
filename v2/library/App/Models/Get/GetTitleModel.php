<?php

declare (strict_types = 1);

namespace App\Models\Get;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class GetTitleModel
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
     * @param string $title
     * @param string $limit
     * @param string $offset
     * @return void
     */
    public function data(
        string $dbname,
        string $title,
        string $limit,
        string $offset
    ) {

        $this->getConnection();

        $query = "SELECT * FROM {$dbname} WHERE title LIKE '%{$title}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->__database->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
