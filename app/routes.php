<?php
use app\controllers\HomeController;
use app\controllers\admin\LoginController;

$router->addRoute('GET','/', HomeController::class, 'index' );
$router->addRoute('GET','/admin/login', LoginController::class, 'index' );


