<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'app' . DIRECTORY_SEPARATOR);

/**
 * class autoloader
 */
spl_autoload_register(function ($class) {
    $file = ROOT_PATH . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        include_once $file;
        return true;
    }
    return false;
});


try {
    \app\core\Env::init();
    $router = new \app\core\Router();
    require_once APP_PATH . 'routes.php';
    $router->init();
} catch (\Exception $e) {
    http_response_code(500);
    die('Error: ' . $e->getMessage());
}

