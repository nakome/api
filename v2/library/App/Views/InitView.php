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

use App\Controllers\RouteController as RouteController;
use Vendor\Router\Router as Router;

/**
 * Models
 */
class InitView
{
    /**
     * Construct.
     */
    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Routes.
     */
    public function routes()
    {
        $R = $this->router;
        $R->route(
            [
                '/(:any)',
                '/(:any)/(:any)',
                '/(:any)/(:any)/(:any)',
            ],
            fn(
                string $type = '',
                string $dbname = '',
                string $any = ''
            ) =>
            RouteController::createRouteControl($type, $dbname, $any)
        );
    }

    /**
     * Init application.
     */
    public function init()
    {
        $this->routes();
        $this->router->launch();
    }
}
