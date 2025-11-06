<?php

namespace app\interfaces;

/**
 * Interface for routing with language support
 */
interface RouteInterface
{
    /**
     * Extract language from URI and return it
     *
     * @param string $uri
     * @return string Language code or default
     */
    public function extractLanguage(string $uri): string;

    /**
     * Build URL with language
     *
     * @param string $path
     * @param string|null $lang
     * @return string
     */
    public static function url(string $path, ?string $lang = null): string;

    /**
     * Add a public route
     *
     * @param string $httpMethod
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function addRoute(string $httpMethod, string $uri, string $controller, string $method): void;

    /**
     * Add a protected route
     *
     * @param string $httpMethod
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function addProtectedRoute(string $httpMethod, string $uri, string $controller, string $method): void;

    /**
     * Initialize routing and dispatch request
     *
     * @return void
     */
    public function init(): void;
}