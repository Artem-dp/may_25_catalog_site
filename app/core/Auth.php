<?php

namespace app\core;

use app\interfaces\AuthInterface;

class Auth implements AuthInterface
{
    static private $envLogin = 'bob';
    static private $envPass;
    public static function login(string $username, string $password): bool
    {
        self::$envPass = password_hash('1234', PASSWORD_DEFAULT);
        if ((password_verify($password, self::$envPass)) && self::$envLogin === $username){
            $_SESSION['authentic'] = true;
            return true;
        }
        return false;
    }
    public static function check(): bool
    {
        if ($_SESSION['authentic']){
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function user(): ?array
    {
        $isLoginUser = self::check();
        if ($isLoginUser){
            return ['user_name' => self::$envLogin,
                  'user_pass' => self::$envPass,
                ];
        }
        return null;
    }
}