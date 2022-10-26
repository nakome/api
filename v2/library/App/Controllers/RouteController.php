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

use App\Controllers\Create\CreateController as CreateController;
use App\Controllers\Delete\DeleteController as DeleteController;
use App\Controllers\Delete\DropController as DropController;
use App\Controllers\Export\ExportController as ExportController;
use App\Controllers\Get\GetAllController as GetAllController;
use App\Controllers\Get\GetAuthorController as GetAuthorController;
use App\Controllers\Get\GetCategoryController as GetCategoryController;
use App\Controllers\Get\GetCreatedController as GetCreatedController;
use App\Controllers\Get\GetFilterController as GetFilterController;
use App\Controllers\Get\GetNameController as GetNameController;
use App\Controllers\Get\GetPublicController as GetPublicController;
use App\Controllers\Get\GetTitleController as GetTitleController;
use App\Controllers\Get\GetTokenController as GetTokenController;
use App\Controllers\Get\GetUidController as GetUidController;
use App\Controllers\Get\GetUpdatedController as GetUpdatedController;
use App\Controllers\Insert\InsertController as InsertController;
use App\Controllers\Update\UpdateController as UpdateController;
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
