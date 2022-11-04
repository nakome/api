<?php

declare (strict_types = 1);

namespace App\Models\Get;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class GetTotalModel
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
        string $dbname
    ) {

        $this->getConnection();

        $query = "SELECT COUNT(*) as total FROM {$dbname}";
        $stmt = $this->__database->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
