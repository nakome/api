<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models\Create;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

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
        $sqliteSql = <<<STR
        CREATE TABLE IF NOT EXISTS '$dbname' (
            'uid' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
            'name' TEXT DEFAULT '$dbname title' UNIQUE,
            'author' TEXT DEFAULT 'Anonymous',
            'author_info' TEXT DEFAULT '',
            'title' TEXT DEFAULT '? title' UNIQUE,
            'description' TEXT DEFAULT '? description',
            'content' TEXT DEFAULT '[]',
            'created' DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            'updated' DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            'category' TEXT,
            'token' TEXT,
            'public' INTEGER DEFAULT 0
        );
        STR;

        $mysqlSql = <<<STR
        CREATE TABLE IF NOT EXISTS $dbname (
            uid INT(11) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL UNIQUE,
            author VARCHAR(50) NULL DEFAULT 'Anonymous',
            author_info VARCHAR(255) NULL DEFAULT '',
            title VARCHAR(50) NULL DEFAULT '? title',
            description VARCHAR(140) NULL DEFAULT '? description',
            content JSON,
            created DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            updated DATETIME,
            category VARCHAR(25) NULL DEFAULT 'default',
            public INT(1) NULL DEFAULT 1,
            token VARCHAR(50) NULL,
            PRIMARY KEY (uid)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;
        STR;

        return $this->__database->query((constant('DB_TYPE') == 'sqlite') ? $sqliteSql : $mysqlSql);
    }
}
