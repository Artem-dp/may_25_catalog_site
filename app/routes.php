<?php

use app\controllers\admin\AboutController;
use app\controllers\HomeController;
use app\controllers\admin\LoginController;
use app\controllers\admin\DashboardController;

$router->addRoute('GET','/', HomeController::class, 'index' );
$router->addRoute('GET','/admin/login', LoginController::class, 'index' );
$router->addRoute('GET','/admin/about', AboutController::class, 'index' );
$router->addRoute('POST','/admin/login', LoginController::class, 'login' );
$router->addProtectedRoute('GET','/admin/dashboard', DashboardController::class, 'index' );


