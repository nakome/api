<?php

declare (strict_types = 1);

namespace Vendor\Utils;

defined('ACCESS') or exit('Sorry, you dont have access file.');

/**
 * Utils
 */
class Utils
{
    /**
     * Alternative format Python
     *
     * <code>
     *   format("hello {}",array('world'));
     * </code>
     *
     * @param string $msg
     * @param array $vars
     *
     * @return string
     */
    public static function format(
        string $msg,
        array $vars
    ): string {
        $vars = (array)$vars;

        $msg = preg_replace_callback('#\{\}#', function ($r) {
            static $i = 0;
            return '{' . ($i++) . '}';
        }, $msg);

        return str_replace(
            array_map(function ($k) {
                return '{' . $k . '}';
            }, array_keys($vars)),

            array_values($vars),

            $msg
        );
    }

    /**
     * Random uid
     *
     * @param string $input
     * @param int $strlen
     *
     * @return string
     */
    public static function randomUid(
        string $input = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890",
        int $strlen = 6
    ): string {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strlen; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return uniqid($random_string);
    }

    /**
     * Log files
     *
     * @param array $data
     *
     * @return void
     */
    public static function log(string $name, string $data): void
    {
        $logFile = ROOT_DIR . '/log.txt';
        if (DEBUG) {
            $fileOpen = fopen($logFile, 'a+') or die("Can't open file.");
            $body = "\n========== {$name} ==========\n";
            $body .= "== " . $data . "\n";
            $body .= "== Date:" . date('d/m/Y H:m:s');

            // create line with body length
            $divider = str_repeat('=', strlen($name));
            $body .= "\n==========={$divider}===========\n";

            fwrite($fileOpen, $body);
            fclose($fileOpen);
        } else {
            if (file_exists($logFile) && is_file($logFile)) {
                unlink($logFile);
            }
        }
    }
}
