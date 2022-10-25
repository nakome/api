<?php

// global vars
define('ACCESS', true);
define('ACCESSINFO', 'Sorry, you dont have access file.');
define('ROOT_DIR',str_replace(DIRECTORY_SEPARATOR, '/', getcwd()));
define('LIBRARY', ROOT_DIR.'/library');
define('DATABASE', ROOT_DIR.'/data/data.db');
define('CONFIG', ROOT_DIR.'/data/config.php');
define('VIEWS', ROOT_DIR.'/public');

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
$App = new App\App();
$App->init();