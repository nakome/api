<?php

declare (strict_types = 1);

namespace App\Controllers;

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
use App\Controllers\Log\LogController as LogController;
use App\Controllers\Token\TokenController as TokenController;
use App\Controllers\Update\UpdateController as UpdateController;
use App\Models\Create\ExistsTableModel as ExistsTableModel;
use App\Views\MessageView as MessageView;
use Vendor\Url\Url as Url;
use Vendor\Utils\Utils as Utils;

/**
 * Routes Controller
 */
class RouteController
{

    /**
     * Check if the table exists
     *
     * @param string $dbname
     * @return boolean
     */
    private static function __checkIfTableExists(
        string $dbname
    ): bool {
        // check if exists the table $dbname
        $ExistsTableModel = new ExistsTableModel();
        if ($ExistsTableModel->data($dbname)) {
            return true;
        }
        return false;
    }

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

        // Error message if not run calling controller
        $errorMsg = "Error specifying access address, try [create,insert,update,delete,get,filter,export,drop]";

        switch ($type) {
            case 'create':
                if (!self::__checkIfTableExists($dbname)) {
                    CreateController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} already exists!");
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'insert':
                if (self::__checkIfTableExists($dbname)) {
                    InsertController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'update':
                if (self::__checkIfTableExists($dbname)) {
                    UpdateController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'delete':
                if (self::__checkIfTableExists($dbname)) {
                    DeleteController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'get':
                if (self::__checkIfTableExists($dbname)) {
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
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'filter':
                if (self::__checkIfTableExists($dbname)) {
                    GetFilterController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'export':
                if (self::__checkIfTableExists($dbname)) {
                    ExportController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                break;
            case 'drop':
                if (self::__checkIfTableExists($dbname)) {
                    DropController::data($dbname);
                } else {
                    MessageView::setMsg("The table {$dbname} not exists!",'666');
                }
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
            case 'token':
                TokenController::options($dbname);
                break;
            case 'log':
                LogController::options($dbname);
                break;
            default:
                // set error message if not call controller
                MessageView::setMsg($errorMsg);
                break;
        }
        exit(1);
    }
}
