<?php

namespace app\core;

use app\interfaces\AuthInterface;

class Auth implements AuthInterface
{
    static protected function getAdminName(): string
    {
        return Env::config('admin_name');
    }
    static protected function getAdminPassHash(): string
    {
        return Env::config('admin_pass');
    }
    public static function login(string $username, string $password): bool
    {
        if ((password_verify($password, self::getAdminPassHash()))
            && self::getAdminName() === $username){
            $_SESSION['authentic'] = $username;
            return true;
        }
        return false;
    }
    public static function check(): bool
    {
        if (isset($_SESSION['authentic'])){
                return true;
            }
        return false;
    }

    public static function logout(): void
    {
        if (isset($_SESSION['authentic'])){
            unset($_SESSION['authentic']);
        };

    }

    public static function user(): ?array
    {
        $isLoginUser = self::check();
        if ($isLoginUser){
            return [
                'user_name' => self::getAdminName(),
                ];
        }
        return null;
    }
}