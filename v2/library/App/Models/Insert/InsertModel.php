<?php

declare (strict_types = 1);

namespace App\Models\Insert;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class InsertModel
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
     * @param array $data
     * @return boolean
     */
    public function data(
        string $dbname,
        array $data
    ): bool {

        $this->getConnection();

        $sql = "INSERT INTO {$dbname} (name,author,author_info,title,description,category, public, token,content) VALUES (:name,:author,:author_info,:title,:description,:category,:public,:token,:content)";
        $stmt = $this->__database->prepare($sql);
        return $stmt->execute($data);
    }
}
