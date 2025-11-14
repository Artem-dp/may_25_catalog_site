<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\core\Language;

class LanguagesController extends Controller
{
    // страница со списком языков
    public function index()
    {
        $languages = Language::getLanguages();
        $current = Language::getCurrentLanguage();

        $this->render('admin/language_template', [
            'languages' => $languages,
            'current' => $current
        ], 'site/layouts/admin_template');
    }

    // переключение языка
//    public function switch()
//    {
//        $code = $_GET['code'] ?? 'en';
//        LanguageManager::setLanguage($code);
//        header('Location: /admin/language');
//        exit;
//    }
}