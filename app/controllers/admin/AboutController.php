<?php
namespace app\controllers\admin;

use app\models\admin\AboutModel;

class AboutController
{
    /**
     * Страница редактирования раздела "О нас" в админке.
     */
    public function index(): void
    {
        session_start();

        $lang = $_GET['lang'] ?? 'ru';
        $model = new AboutModel();
        $data = $model->getByLang($lang);

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        // Путь к шаблону admin/about_template.php
        include __DIR__ . '/../../resources/views/admin/about_template.php';
    }

    /**
     * Сохранение изменений раздела "О нас".
     */
    public function save(): void
    {
        session_start();

        $lang    = $_POST['lang'] ?? 'ru';
        $title   = trim($_POST['title'] ?? '');
        $content = $_POST['content'] ?? null;

        if ($title === '') {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'msg'  => 'Заголовок обязателен'
            ];
            header("Location: /admin/about?lang={$lang}");
            exit;
        }

        $model = new AboutModel();
        $ok = $model->upsert($lang, $title, $content);

        $_SESSION['flash'] = $ok
            ? ['type' => 'success', 'msg' => 'Сохранено успешно']
            : ['type' => 'danger',  'msg' => 'Ошибка при сохранении'];

        header("Location: /admin/about?lang={$lang}");
        exit;
    }
}
