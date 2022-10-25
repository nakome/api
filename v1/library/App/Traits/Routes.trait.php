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
trait Routes
{

    /**
     *  Render Assets.
     *
     *  @param array $patterns  array
     *  @param callable $callback  function
     */
    public function route(
        array $patterns,
        callable $callback
    ): void {
        // if not in array
        if (!is_array($patterns)) {
            $patterns = array($patterns);
        }
        foreach ($patterns as $pattern) {
            // trim /
            $pattern = trim($pattern, '/');

            // get any num all
            $pattern = str_replace(
                array('\(', '\)', '\|', '\:any', '\:num', '\:all', '#'),
                array('(', ')', '|', '[^/]+', '\d+', '.*?', '\#'),
                preg_quote($pattern, '/')
            );

            // this pattern
            $this->routes['#^' . $pattern . '$#'] = $callback;
        }
    }

    /**
     * Routes.
     */
    public function routes()
    {
        /*
         *
         * p = post
         * g = get
         * u = update
         * d = delete
         * s = search
         *
         * - Available routes
         * - localhost/api/[post,get]/dbname
         * - localhost/api/[post,get,put,del,search]/dbname/?filter=blog&length=10
         * - localhost/api/g/dbname/?filter=blog&length=10
         */
        $this->route([
            '/(:any)/(:any)', // localhost/api/[post,get]/clients
            '/(:any)/(:any)/(:any)', // localhost/api/[post,get]/?data=post
        ], fn(
            string $type = '',
            string $dbname = '',
            string $any = ''
        ) => $this->callableRoutes($type, $dbname, $any));
    }

    /**
     *  launch routes.
     */
    public function launch()
    {
        // Turn on output buffering
        ob_start();
        // launch
        $url = $_SERVER['REQUEST_URI'];
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if (strpos($url, $base) === 0) {
            $url = substr($url, strlen($base));
        }
        $url = trim($url, '/');
        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                //return function
                return call_user_func_array($callback, array_values($params));
            }
        }
        // Page not found
        if ($this->is404($url)) {
            @header('Content-type: application/json');
            $arr = array(
                'STATUS' => 404,
                'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                'OPTS' => $_GET,
            );
            exit(json_encode($arr));
        }
        // end flush
        ob_end_flush();
        exit;
    }

    /**
     * Callback routes
     *
     * @param string $type
     * @param string $dbname
     * @param string $any
     *
     * @return mixed
     */
    public function callableRoutes(
        string $type = '',
        string $dbname = '',
        string $any = ''
    ) {

        $this->cors();

        switch ($type) {
            case 'c':
                return $this->createTable($dbname);
                break;
            case 'p':
                return $this->postData($dbname);
                break;
            case 'u':
                return $this->putData($dbname);
                break;
            case 'd':
                return $this->delData($dbname);
                break;
            case 'g':
                return $this->getData($dbname);
                break;
            case 'f':
                return $this->filterData($dbname);
                break;
            case 'export':
                return $this->exportTable($dbname);
                break;
            case 'drop':
                return $this->destroy($dbname);
                break;
        }
        exit(1);
    }
}
