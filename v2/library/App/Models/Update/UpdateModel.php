<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models\Update;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class UpdateModel
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
     * @param string $uid
     * @return boolean
     */
    public function data(
        string $dbname,
        array $data,
        string $uid
    ): bool {

        $this->getConnection();

        $sql = "UPDATE {$dbname} SET name=:name, author=:author, author_info=:author_info, title=:title, description=:description, category=:category,public=:public,token=:token,content=:content,created=:created,updated=:updated WHERE uid=:uid";
        $stmt = $this->__database->prepare($sql);
        return $stmt->execute($data);
    }
}
