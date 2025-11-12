<?php

namespace app\interfaces;

/**
 * Interface for authentication
 */
interface AuthInterface
{
    /**
     * Login user
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function login(string $username, string $password): bool;

    /**
     * Check if user authenticated
     *
     * @return bool
     */
    public static function check(): bool;

    /**
     * @return void
     */
    public static function logout(): void;

    /**
     * Get user data
     *
     * @return array|null User data or null if not authenticated
     */
    public static function user(): ?array;
}