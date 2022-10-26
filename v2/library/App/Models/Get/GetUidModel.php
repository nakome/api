<?php

declare (strict_types = 1);

namespace App\Models\Get;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class GetUidModel
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
     * @param string $uid
     * @return void
     */
    public function data(
        string $dbname,
        string $uid
    ) {

        $this->getConnection();

        $stmt = $this->__database->prepare("SELECT * FROM {$dbname} WHERE uid=:uid");
        $stmt->execute(array(':uid' => (int)$uid));
        return $stmt->fetch();
    }
}