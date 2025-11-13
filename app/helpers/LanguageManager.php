<?php

namespace app\helpers;

use app\interfaces\LanguageAwareInterface;
use app\models\admin\LanguagesModel;

class LanguageManager implements LanguageAwareInterface
{
    // получаем все языки из базы
    public static function getLanguages(): array
    {
        $model = new LanguagesModel();
        $languages = $model->getAll();

        // преобразуем результат в ассоциативный массив вида ['en' => 'English', ...]
        $result = [];
        foreach ($languages as $lang) {
            $result[$lang['code']] = $lang['name'];
        }

        return $result;
    }

    //получаем текущий язык из сессии
    public static function getCurrentLanguage(): string
    {
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = 'en'; // по умолчанию
        }
        return $_SESSION['language'];
    }

    //устанавливаем текущий язык
    public static function setLanguage(string $langCode): void
    {
        $_SESSION['language'] = $langCode;
    }
}