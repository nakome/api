<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

/**
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);


return [
    "url" => "http://localhost/api/v1",
    // bin2hex(random_bytes((50 - (50 % 2)) / 2));
    "token" => "1234567890",

    "dbType" => "sqlite",
    "dbFile" => __DIR__ .'/data.db',
    "dbUser" => "",
    "dbPass" => "",
];