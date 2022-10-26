<?php

// global vars
define('ACCESS', true);
define('ACCESSINFO', 'Sorry, you dont have access file.');
define('ROOT_DIR',str_replace(DIRECTORY_SEPARATOR, '/', getcwd()));
define('LIBRARY', ROOT_DIR.'/library');

/* Token & url */
define("URL","http://localhost/api/v1");
define("TOKEN","e856285fd7c4c0635af8d47c276e09");

/* Database connection values */
define("DB_TYPE", "sqlite");// sqlite,mysql
define("DB_FILE", ROOT_DIR.'/data/data.db');
define('DB_HOST', "localhost:3306"); //only for mysql
define('DB_NAME', "demo"); //only for mysql
define('DB_USER', 'root');//only for mysql
define('DB_PASS', 'root');//only for mysql
define('DB_CHARSET', 'utf8mb4');//only for mysql

// Develoment true
define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('track_errors', 1);
    ini_set('html_errors', 1);
    error_reporting(E_ALL | E_STRICT | E_NOTICE);
}

// include Router
require __DIR__.'/library/autoload.php';

// init App
$App = new App\Views\InitView();
$App->init();