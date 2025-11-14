<?php

use app\controllers\admin\AboutController;
use app\controllers\HomeController;
use app\controllers\admin\LoginController;
use app\controllers\admin\CatalogController;
use app\controllers\admin\DashboardController;
use app\controllers\admin\LanguagesController;

$router->addRoute('GET','/', HomeController::class, 'index' );
$router->addRoute('GET','/admin', LoginController::class, 'redirectToDashboard' );
$router->addRoute('GET','/admin/login', LoginController::class, 'index' );
$router->addRoute('GET','/admin/about', AboutController::class, 'index' );
$router->addRoute('POST','/admin/about/save', AboutController::class, 'save' );
$router->addRoute('POST','/admin/login', LoginController::class, 'login' );
$router->addRoute('GET','/admin/logout', LoginController::class, 'logout' );

$router->addProtectedRoute('GET','/admin/dashboard', DashboardController::class, 'index' );
$router->addProtectedRoute('GET','/admin/catalog', CatalogController::class, 'index' );
$router->addProtectedRoute('POST','/admin/catalog/upload', CatalogController::class, 'upload' );
$router->addProtectedRoute('GET','/admin/languages', LanguagesController::class, 'index');



$router->addProtectedRoute('/admin/languages', LanguagesController::class, 'index');
$router->addProtectedRoute('/admin/languages/add', LanguagesController::class, 'add');
$router->addProtectedRoute('/admin/languages/delete', LanguagesController::class, 'delete');


