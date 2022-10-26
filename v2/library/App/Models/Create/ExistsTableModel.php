<?php

declare (strict_types = 1);

namespace App\Models\Create;

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
    ) {

        if (constant("DB_TYPE") == 'sqlite') {
            //mysql
            $this->getConnection();

            $query = "SELECT name FROM sqlite_master WHERE type='table' AND name='{$dbname}'";
            $stmt = $this->__database->prepare($query);
            $stmt->execute();
            $output = $stmt->fetchAll();
            return $output;
        } else {
            //mysql
            //mysql
            $this->getConnection();

            $query = "SELECT * FROM {$dbname}";
            $stmt = $this->__database->prepare($query);
            return $stmt->execute();
        }
    }
}
