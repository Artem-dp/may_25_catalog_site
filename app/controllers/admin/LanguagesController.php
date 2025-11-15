<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Language;
use app\models\admin\LanguagesModel;

class LanguagesController extends Controller
{
    // страница со списком языков
    public function index()
    {
        $languages = Language::getLanguages();
        $current = Language::getCurrentLanguage();

        $this->render('admin/languages_template', [
            'languages' => $languages,
            'current' => $current
        ], 'site/layouts/admin_template');
    }
    public function add()
    {
        $model = new LanguagesModel();

        $code = $_POST['code'] ?? null;
        $name = $_POST['name'] ?? null;

        if ($code && $name) {
            $model->add($code, $name);
        }

        header("Location: /admin/languages");
    }

    public function delete()
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $model = new LanguagesModel();
            $model->delete($id);
        }

        header("Location: /admin/languages");
    }
}