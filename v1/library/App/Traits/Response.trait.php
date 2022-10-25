<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

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
trait Response
{

    /**
     * Create filter response.
     *
     * @param string $filter
     * @param array $response
     *
     * @return array
     */
    public function createFilterResponse(
        string $filter, 
        array $response
    ): array
    {
        $arr = [];
        foreach ($response as $row) {
            if ($filter === "content") {
                continue;
            }
            $arr[] = $row[$filter];
        }
        return array_unique($arr);
    }

    /**
     * Create output response.
     *
     * @param array $response
     *
     * @return array
     */
    public function createSingleResponse(array $response): array
    {
        $arr = [
            'uid' => (int)$response['uid'],
            'name' => (string)$response['name'],
            'author' => (string)$response['author'],
            'author_info' => (string)$response['author_info'],
            'category' => (string)$response['category'],
            'content' => is_array(json_decode($response['content'])) ? json_decode($response['content'], true) : $response['content'],
            'public' => (string)$response['public'],
            'token' => (string)$response['token'],
            'title' => (string)$response['title'],
            'description' => (string)$response['description'],
            'created' => (string)$response['created'],
            'updated' => (string)$response['updated'],
        ];
        return $arr;
    }

    /**
     * Create output response.
     *
     * @param array $response
     *
     * @return array
     */
    public function createFullResponse(array $response): array
    {
        $arr = [];
        foreach ($response as $row) {
            $arr[] = [
                'uid' => (int)$row['uid'],
                'name' => (string)$row['name'],
                'author' => (string)$row['author'],
                'author_info' => (string)$row['author_info'],
                'category' => (string)$row['category'],
                'content' => is_array(json_decode($row['content'])) ? json_decode($row['content'], true) : $row['content'],
                'public' => (string)$row['public'],
                'token' => (string)$row['token'],
                'title' => (string)$row['title'],
                'description' => (string)$row['description'],
                'created' => (string)$row['created'],
                'updated' => (string)$row['updated'],
            ];
        }
        return $arr;
    }
}
