<?php

declare (strict_types = 1);

namespace App\Models\Insert;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class ExistsTitleModel
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
     * Check if exists title
     *
     * @param string $dbname
     * @param string $title
     * @return void
     */
    public function checkIfExists(
        string $dbname,
        string $title
    ): bool {

        $this->getConnection();

        // check if title exists
        $query = "SELECT * FROM {$dbname} WHERE title=:title";
        $stmt = $this->__database->prepare($query);
        $stmt->execute([":title" => $title]);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return true;
        }
        return false;
    }
}
