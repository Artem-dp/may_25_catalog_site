<?php
namespace app\controllers\admin;

use app\core\Controller;
use app\models\admin\AboutModel;

class AboutController extends Controller
{
    public function index(): void
    {
        $lang = $_GET['lang'] ?? 'ru';

        $model = new AboutModel();
        $data  = $model->getByLang($lang);

        $this->render('admin/about_template', $data, 'site/layouts/admin_template');
    }

    /**
     * Сохранение изменений раздела "О нас".
     */
    public function save(): void
    {
        $lang    = $_POST['lang'] ?? 'ru';
        $title   = trim($_POST['title'] ?? '');
        $content = $_POST['content'] ?? null;

        if ($title === '') {
            header("Location: /admin/about?lang={$lang}");
            exit;
        }

        $model = new AboutModel();
        $model->upsert($lang, $title, $content);

        header("Location: /admin/about?lang={$lang}");
        exit;
    }
}
