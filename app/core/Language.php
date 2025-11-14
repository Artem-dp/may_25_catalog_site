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

    public static function getCurrentLanguage(): string
    {
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = Env::config('DEFAULT_LANG');
        }
        return $_SESSION['language'];
    }

    public static function setLanguage(string $langCode): void
    {
        $_SESSION['language'] = $langCode;
    }
}
