<?php

declare (strict_types = 1);

namespace App\Controllers\Token;

defined('ACCESS') or exit(ACCESSINFO);

use Vendor\Auth\Auth as Auth;

class TokenController
{

    /**
     * Generate Token
     *
     * @return void
     */
    private static function __generate()
    {
        $auth = new Auth();
        $token = $auth->generateBearerToken(20);
        $output = "Success, the token is {$token}";
        exit(die($output));
    }

    /**
     * Token options
     *
     * @param string $opts
     * @return void
     */
    public static function options(string $opts)
    {
        switch ($opts) {
            case 'generate':
                self::__generate();
                break;
        }

        exit();
    }
}
