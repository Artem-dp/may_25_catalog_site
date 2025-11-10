<?php

namespace app\core;

use app\exceptions\ControllerNotFoundException;
use app\exceptions\RouteNotFoundException;
use http\Exception\BadMethodCallException;

class Router
{
    protected array $routes = [];
    protected array $protectedRoutes = [];


    /**
     * Adds a new public route to the routing table.
     *
     * @param string $httpMethod
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function addRoute(string $httpMethod, string $uri, string $controller, string $method): void
    {
        $this->routes[] = [
            'method' => $httpMethod,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $method,
        ];
    }

    /**
     * Adds a new protected route to the routing table.
     *
     * @param string $httpMethod
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return void
     */
    public function addProtectedRoute(string $httpMethod, string $uri, string $controller, string $method): void
    {
        $this->protectedRoutes[] = [
            'method' => $httpMethod,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $method,
        ];
    }


    /**
     * @throws RouteNotFoundException|ControllerNotFoundException
     */
    public function init(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = $this->extractLanguageFromUri($uri);
        $this->dispatch($httpMethod, $uri);
    }

    /**
     * Dispatches the request to the appropriate controller method.
     * @throws RouteNotFoundException|ControllerNotFoundException
     */
    protected function dispatch(string $httpMethod, string $uri): void
    {
        // check public routes
        foreach ($this->routes as $route) {
            if ($route['method'] === $httpMethod && $route['uri'] === $uri) {
                $controller = $route['controller'];
                $action = $route['action'];
                $this->callController($route['controller'], $route['action']);
                return;
            }
        }

        // check protected routes
        foreach ($this->protectedRoutes as $route) {
            if ($route['method'] === $httpMethod && $route['uri'] === $uri) {
                if (!Auth::check()) {
                    $loginUrl = self::url('/admin/login');
                    $this->redirect($loginUrl);
                    return;
                }

                $this->callController($route['controller'], $route['action']);
                return;
            }
        }

        throw new RouteNotFoundException();

    }

    /**
     * Redirects to a new URI.
     * @param string $uri
     * @param int $statusCode
     * @return void
     */
    protected function redirect(string $uri, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: $uri");
        exit;
    }

    /**
     * Calls the controller method
     * @throws ControllerNotFoundException
     */
    protected function callController(string $controller, string $action, $params = []): void
    {
        //check class availability
        if (!class_exists($controller)) {
            throw new ControllerNotFoundException($controller);
        }
        $controllerInstance = new $controller();
        //check method availability
        if (!method_exists($controllerInstance, $action)) {
            throw new \BadMethodCallException("Method '$action' not found in controller '$controller'");
        }

        //call method
        $controllerInstance->$action(...$params);
    }

    private function extractLanguageFromUri(string $uri): string
    {
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        // Admin routes ignore language prefix
        if (str_starts_with($uri, '/admin')) {
            Language::setLanguage(Language::getDefaultLanguage());
            return $uri;
        }


        // Check if URI starts with /{lang}/
        if (preg_match('#^/([a-z]{2})(/.*)?$#', $uri, $matches)) {
            $langCode = $matches[1];
            $pathWithoutLang = $matches[2] ?? '/';

            // сheck if language is available
            if (Language::isAvailable($langCode)) {
                // if default language, remove lang prefix
                if ($langCode === Language::getDefaultLanguage()) {
                    $this->redirect($pathWithoutLang, 301);
                }
                Language::setLanguage($langCode);
                return $pathWithoutLang;
            }
        }
        Language::setLanguage(Language::getDefaultLanguage());
        return $uri;
    }

    /**
     * Generate localized URL
     * @param string $path
     * @param string|null $lang language code, null for current language
     * @return string
     */
    public static function url(string $path, ?string $lang = null): string
    {
        if ($lang === null) {
            $lang = Language::getCurrentLanguage();
        }

        if (!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }
        $defaultLang = Language::getDefaultLanguage();
        if ($lang === $defaultLang) {
            return $path;
        }
        return '/' . $lang . $path;
    }
}