<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

// traits
require LIBRARY . '/App/Traits/Utils.trait.php';
require LIBRARY . '/App/Traits/Auth.trait.php';
require LIBRARY . '/App/Traits/Url.trait.php';
require LIBRARY . '/App/Traits/Post.trait.php';
require LIBRARY . '/App/Traits/Put.trait.php';
require LIBRARY . '/App/Traits/Del.trait.php';
require LIBRARY . '/App/Traits/Response.trait.php';
require LIBRARY . '/App/Traits/Get.trait.php';
require LIBRARY . '/App/Traits/Create.trait.php';
require LIBRARY . '/App/Traits/Database.trait.php';
require LIBRARY . '/App/Traits/Views.trait.php';
require LIBRARY . '/App/Traits/Routes.trait.php';

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2016 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
final class App
{
    //traits
    use traits\Utils;
    use traits\Auth;
    use traits\Url;
    use traits\Post;
    use traits\Put;
    use traits\Response;
    use traits\Del;
    use traits\Get;
    use traits\Create;
    use traits\Views;
    use traits\Database;
    use traits\Routes;

    private $__languages = [
        "tableNotExists" => "Error, la tabla {} no existe",
        "successCreateTable" => "Correcto, la tabla {} se ha creado",
        "errorCreateTable" => "Error, no se pudo crear la tabla {}",
        "successCreateRow" => "Correcto, se ha creado la nueva fila",
        "errorCreateRow" => "Error, no se pudo crear la nueva fila",
        "successUpdateRow" => "Correcto, el id {} se ha actualizado",
        "errorUpdateRow" => "Error, no se pudo actualizar el identificador {}",
        "successDeleteRow" => "Correcto, el identificador {} se ha eliminado",
        "errorDeleteRow" => "Error, no se pudo eliminar el identificador {}",
        "successDeleteTable" => "Correcto, la tabla {} se ha quitado",
        "errorDeleteTable" => "Error, no se pudo quitar la tabla {}",
        "errotNotConsult" => "Lo sentimos, la consulta en '{}' no ha obtenido resultados ",
    ];

    /**
     * Construct.
     */
    public function __construct()
    {
        // lista de bases de datos
        $this->config = require CONFIG;
    }

    /**
     * Create static instance
     *
     * @return static
     */
    public static function run()
    {
        return new static();
    }

    /**
     * Init application.
     */
    public function init()
    {
        // add routes
        $this->routes();
        // launch router
        $this->launch();
    }

}
