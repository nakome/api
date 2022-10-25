<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

use PDO;

/*
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2020 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
trait Create
{
    /**
     * Create table.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function createTable(
        string $dbname = ''
    ): void {
        if ($this->auth()) {
            // connect database
            $db = $this->dbConnect();
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
            $output = $db->query($sql);
            if ($output) {
                $this->log("Create {$dbname}",(string) "Success create table ");
                $this->createApiResponse([
                    'MESSAGE' => $this->format(
                        $this->__languages['successCreateTable'], [$dbname]
                    ),
                ]);
            } else {
                $this->log("Create {$dbname}",(string) "Error create table ");
                $this->createApiResponse([
                    'MESSAGE' => $this->format(
                        $this->__languages['errorCreateTable'], [$dbname]
                    ),
                ]);
            }
        }

        $this->createApiResponse();
    }

    /**
     * Export table
     *
     * @param string $dbname
     */
    public function exportTable(string $dbname)
    {
        // [url]api/export/[dbname]
        if ($this->auth()) {
            try {
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname}";
                $stmt = $pdo->prepare($sql);
                $output = $stmt->execute();
                if ($output) {
                    $delimiter = ",";
                    $filename = $dbname . " " . date('Y-m-d') . ".csv";
                    // Create a file pointer
                    $f = fopen('php://memory', 'w');
                    // Set column headers
                    $fields = ['uid', 'name', 'author', 'author_info', 'title', 'description', 'content', 'created', 'updated', 'category', 'public', 'token'];
                    fputcsv($f, $fields, $delimiter);
                    // Output each row of the data, format line as csv and write to file pointer
                    while ($row = $stmt->fetch()) {
                        $lineData = [$row['uid'], $row['name'], $row['author'], $row['author_info'], $row['title'], $row['description'], $row['content'], $row['created'], $row['updated'], $row['category'], $row['public'], $row['token']];
                        fputcsv($f, $lineData, $delimiter);
                    }
                    // Move back to beginning of file
                    fseek($f, 0);
                    // Set headers to download file rather than displayed
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $filename . '";');
                    //output all remaining data on a file pointer
                    fpassthru($f);
                    $this->log("Export data {$dbname}",(string) "Success export data");
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        } else {
            $this->log("Export data {$dbname}",(string) "Error export data");
            $this->displayJsonView([
                'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
                'IP' => $this->getIp(),
                'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                'PARAMS' => $_GET,
                'MESSAGE' => $this->format(
                    $this->__languages['errotNotConsult'], [$dbname]
                ),
            ]);
        }
    }

    /**
     * Create response.
     *
     * @return object
     */
    public function createApiResponse(
        array $output = []
    ): object {
        return $this->displayJsonView([
            'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
            'IP' => $this->getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'localhost',
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'PARAMS' => $_GET,
            'TOTAL' => count($output),
            'DATA' => $output ?? []
        ]);
    }
}
