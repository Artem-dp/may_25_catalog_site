<?php

namespace app\controllers\admin;

use app\core\Controller;
use app\helpers\LanguageManager;

class LanguageController extends Controller
{
    // страница со списком языков
    public function index()
    {
        $languages = LanguageManager::getLanguages();
        $current = LanguageManager::getCurrentLanguage();

        $this->render('admin/language_template', [
            'languages' => $languages,
            'current' => $current
        ], 'admin_template');
    }

    // переключение языка
    public function switch()
    {
        $code = $_GET['code'] ?? 'en';
        LanguageManager::setLanguage($code);
        header('Location: /admin/language');
        exit;
    }
}