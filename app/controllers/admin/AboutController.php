<?php
namespace app\controllers\admin;

use app\core\Controller;
use app\core\Env;
use app\models\admin\AboutModel;

class AboutController extends Controller
{
    public function index(): void
    {
        $lang = $_GET['lang'] ?? Env::config('DEFAULT_LANG');

        $model = new AboutModel();
        $data  = $model->getByLang($lang);

        $this->render('admin/about_template', $data, 'site/layouts/admin_template');
    }

    public function save(): void
    {
        $lang    = $_GET['lang'] ?? Env::config('DEFAULT_LANG');
        $title   = trim($_POST['title'] ?? '');
        $content = $_POST['content'] ?? null;

        if ($title === '') {
            header("Location: /admin/about?lang={$lang}");
            exit;
        }

        $model = new AboutModel();
        $model->save($lang, $title, $content);

        header("Location: /admin/about?lang={$lang}");
        exit;
    }
}
