<?php

namespace app\core;

use app\interfaces\LanguageAwareInterface;
use app\models\admin\LanguagesModel;

class Language implements LanguageAwareInterface
{
    public static function getLanguages(): array
    {
        $model = new LanguagesModel();
        return $model->getAll();
    }

    //получаем текущий язык из сессии
    public static function getCurrentLanguage(): string
    {
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = Env::config('DEFAULT_LANG'); // по умолчанию
        }
        return $_SESSION['language'];
    }

    //устанавливаем текущий язык
    public static function setLanguage(string $langCode): void
    {
        $_SESSION['language'] = $langCode;
    }
    public static function getDefaultLanguage(): string
    {
        return Env::config('DEFAULT_LANG');
    }
}
