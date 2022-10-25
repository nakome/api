<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Controllers;

/*
 * Prevenir accesso
 */
defined('ACCESS') or exit(ACCESSINFO);

use App\Controllers\CreateController as CreateController;
use App\Controllers\DeleteController as DeleteController;
use App\Controllers\DropController as DropController;
use App\Controllers\ExportController as ExportController;
use App\Controllers\GetAllController as GetAllController;
use App\Controllers\GetAuthorController as GetAuthorController;
use App\Controllers\GetCategoryController as GetCategoryController;
use App\Controllers\GetCreatedController as GetCreatedController;
use App\Controllers\GetFilterController as GetFilterController;
use App\Controllers\GetNameController as GetNameController;
use App\Controllers\GetTitleController as GetTitleController;
use App\Controllers\GetTokenController as GetTokenController;
use App\Controllers\GetUidController as GetUidController;
use App\Controllers\GetUpdatedController as GetUpdatedController;
use App\Controllers\InsertController as InsertController;
use Vendor\Url\Url as Url;

/**
 * Routes Controller
 */
class RouteController
{
    /**
     * Create Router Control
     *
     * @param string $type
     * @param string $dbname
     * @param string $any
     * @return void
     */
    public static function createRouteControl(
        string $type = '',
        string $dbname = '',
        string $any = ''
    ): void {

        Url::cors();

        switch ($type) {
            case 'create':
                CreateController::data($dbname);
                break;
            case 'insert':
                InsertController::data($dbname);
                break;
            case 'update':
                UpdateController::data($dbname);
                break;
            case 'delete':
                DeleteController::data($dbname);
                break;
            case 'get':
                GetAllController::data($dbname);
                GetUidController::data($dbname);
                GetNameController::data($dbname);
                GetTokenController::data($dbname);
                GetAuthorController::data($dbname);
                GetCategoryController::data($dbname);
                GetTitleController::data($dbname);
                GetCreatedController::data($dbname);
                GetUpdatedController::data($dbname);
                GetPublicController::data($dbname);
                break;
            case 'filter':
                GetFilterController::data($dbname);
                break;
            case 'export':
                ExportController::data($dbname);
                break;
            case 'drop':
                DropController::data($dbname);
                break;
            default:
                echo 'hola';
                break;
        }
        exit(1);
    }
}
