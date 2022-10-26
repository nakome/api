<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Models\Export;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Database\Database as Database;

/**
 * Models
 */
class ExportModel
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
     * @return void
     */
    public function data(
        string $dbname
    ): void {

        $this->getConnection();

        $sql = "SELECT * FROM {$dbname}";
        $stmt = $this->__database->prepare($sql);
        $output = $stmt->execute();
        if($output) {
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
        }
    }
}
