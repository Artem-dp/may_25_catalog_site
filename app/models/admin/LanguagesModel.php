<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Router;
use app\models\admin\LanguagesModel;

class LanguagesController extends Controller
{
    public function index()
    {
        $model = new LanguagesModel();
        $languages = $model->getAll();

        $this->render('languages_template', ['languages' => $languages], 'admin_template');
    }

    public function add()
    {
        $model = new LanguagesModel();
        $model->add($_POST['code'] ?? '', $_POST['name'] ?? '');

        Router::redirect('/admin/languages');
    }

    public function delete()
    {
        $model = new LanguagesModel();
        if (!empty($_GET['id'])) {
            $model->delete((int)$_GET['id']);
        }

        Router::redirect('/admin/languages');
    }
}