<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Views;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Url\Url as Url;

/**
 * Response view
 */
class ResponseView
{

    /**
     * Create filter response.
     *
     * @param string $filter
     * @param array $response
     *
     * @return array
     */
    public static function filter(
        string $filter,
        array $response
    ): array
    {
        $arr = [];
        foreach ($response as $row) {
            if ($filter === "content") {
                continue;
            }
            $arr[$row['uid']] = $row[$filter];
        }
        return array_unique($arr);
    }

    /**
     * Create single response.
     *
     * @param array $response
     *
     * @return array
     */
    public static function single(array $response): array
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
     * Create full response.
     *
     * @param array $response
     *
     * @return array
     */
    public static function full(array $response): array
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

    /**
     * Json output
     *
     * @param array $output
     * @return object
     */
    public static function json(
        array $output = []
    ): object {
        @header('Content-type: application/json');
        exit(json_encode([
            'STATUS' => $_SERVER['REDIRECT_STATUS'] ?? 200,
            'IP' => Url::getIp(),
            'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'localhost',
            'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'PARAMS' => $_GET,
            'TOTAL' => count($output),
            'DATA' => $output ?? [],
        ]));
    }
}
