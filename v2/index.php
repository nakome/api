<?php

// global vars
define('ACCESS', true);
define('ACCESSINFO', 'Sorry, you dont have access file.');
define('ROOT_DIR',str_replace(DIRECTORY_SEPARATOR, '/', getcwd()));
define('LIBRARY', ROOT_DIR.'/library');

/* Token & url */
define("URL","http://localhost/api/v1");
define("TOKEN","55f88217afd0eb63bb71749bd5241a2e91edd97658d6047fb2b0f9f303392aec83829814c2c9730a904a5568bdd0ddf03156c305bd2d03de5e09f5290f2de786");

/* Database connection values */
define("DB_TYPE", "sqlite");
define("DB_FILE", ROOT_DIR.'/data/data.db');
define("DB_USER", "root");
define("DB_PASS", "");


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