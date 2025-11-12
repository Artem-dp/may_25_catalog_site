<?php

namespace app\controllers\admin;

use app\core\Controller;

class DashboardController extends Controller
{
    public function index():void
    {
        $this->render('admin/dashboard_template', [], 'site/layouts/admin_template');
    }
}