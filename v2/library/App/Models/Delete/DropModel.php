<?php

declare (strict_types = 1);

namespace App\Models\Delete;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class DropModel
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
     * @return object
     */
    public function data(
        string $dbname
    ): object {

        $this->getConnection();

        $sql = "DROP TABLE {$dbname}";
        return $this->__database->query($sql);
    }
}
