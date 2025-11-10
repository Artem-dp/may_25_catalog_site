<?php

use app\controllers\admin\AboutController;
use app\controllers\HomeController;
use app\controllers\admin\LoginController;

$router->addRoute('GET','/', HomeController::class, 'index' );
$router->addRoute('GET','/admin/login', LoginController::class, 'index' );
$router->addRoute('GET','/admin/about', AboutController::class, 'index' );


