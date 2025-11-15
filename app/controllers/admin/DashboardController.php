<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Language;
use app\models\admin\CatalogModel;

class DashboardController extends Controller
{
    /**
     * displaying dashboard
     * @return void
     */
    public function index():void
    {
        $this->render('admin/dashboard_template', [
            'langs' => Language::getLanguages(),
            'productsCount' => CatalogModel::getProductsCount(),
            'categoriesCount' => CatalogModel::getCategoriesCount(),
        ], 'site/layouts/admin_template');
    }
}