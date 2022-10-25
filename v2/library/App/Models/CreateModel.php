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

use PDO;
use Vendor\Database\Database as Database;

/**
 * Models
 */
class CreateModel
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

        //SQLite
        $sql = <<<STR
        CREATE TABLE IF NOT EXISTS '$dbname' (
            'uid'   INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
            'name' TEXT DEFAULT '$dbname title',
            'author' TEXT DEFAULT 'Anonymous',
            'author_info' TEXT DEFAULT '',
            'title' TEXT DEFAULT '? titlte',
            'description' TEXT DEFAULT '? description',
            'content' TEXT DEFAULT '[]',
            'created' DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            'updated' DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            'category' TEXT,
            'token' TEXT,
            'public' INTEGER DEFAULT 0
        );
        STR;

        return $this->__database->query($sql);
    }
}
