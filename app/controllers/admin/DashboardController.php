<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Language;

class DashboardController extends Controller
{
    public function index():void
    {
        $this->render('admin/dashboard_template', [
            'langs' => Language::getLanguages(),
            'productsCount' => CatalogController::getProductsCount(),
            'categoriesCount' => CatalogController::getCategoriesCount(),
        ], 'site/layouts/admin_template');
    }
}