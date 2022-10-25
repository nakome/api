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
    "token" => "55f88217afd0eb63bb71749bd5241a2e91edd97658d6047fb2b0f9f303392aec83829814c2c9730a904a5568bdd0ddf03156c305bd2d03de5e09f5290f2de786",

    "dbType" => "sqlite",
    "dbFile" => __DIR__ .'/data.db',
    "dbUser" => "",
    "dbPass" => "",
];