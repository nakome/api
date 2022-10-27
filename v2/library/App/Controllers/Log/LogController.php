<?php

declare (strict_types = 1);

namespace App\Controllers\Log;

defined('ACCESS') or exit(ACCESSINFO);

use App\Views\MessageView as MessageView;
use Vendor\Auth\Auth as Auth;
use Vendor\Url\Url as Url;

/**
 * Log controller
 *
 * [url]api/log/show
 * [url]api/log/clean
 */
class LogController
{
    /**
     * Clean log
     *
     * @param string $dbname
     * @return void
     */
    private static function __clean(): void
    {
        // init auth
        $auth = new Auth();

        // check auth
        if ($auth->check() && $_SERVER['REQUEST_METHOD'] == 'GET') {
            $logFile = ROOT_DIR . '/log.txt';
            if (file_exists($logFile) && is_file($logFile)) {
                unlink($logFile);
                MessageView::setMsg("Success, the log is clean");
                exit();
            } else {
                exit(die("The file not exists!"));
            }
        } else {
            MessageView::setMsg("Error, You don't have access here.", '400');
        }
    }

    /**
     * Show log
     *
     * @param string $dbname
     * @return void
     */
    private static function __show(): void
    {
        // init auth
        $auth = new Auth();

        // check auth
        if ($auth->check() && $_SERVER['REQUEST_METHOD'] == 'GET') {
            $logFile = ROOT_DIR . '/log.txt';
            if (file_exists($logFile) && is_file($logFile)) {
                exit(die(file_get_contents($logFile, true)));
            } else {
                exit(die("The file not exists!"));
            }
        } else {
            MessageView::setMsg("Error, You don't have access here.");
        }
    }

    /**
     * Log Options
     *
     * @param string $opts
     * @return void
     */
    public static function options(string $opts)
    {
        switch ($opts) {
            case 'show':
                self::__show();
                break;
            case 'clean':
                self::__clean();
                break;
            default:
                MessageView::setMsg("Error, You don't have access here.");
                break;
        }
    }
}
