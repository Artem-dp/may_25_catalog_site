<?php

namespace app\core;

use app\interfaces\LanguageAwareInterface;

class Language implements LanguageAwareInterface
{
    public static function getLanguages(): array
    {
//        $model = new LanguagesModel();
//        $languages = $model->getAll();
//
//        // преобразуем результат в ассоциативный массив вида ['en' => 'English', ...]
//        $result = [];
//        foreach ($languages as $lang) {
//            $result[$lang['code']] = $lang['name'];
//        }

        return [
            ['id' => 1, 'code' => 'en', 'name' => 'English'],
            ['id' => 1, 'code' => 'ru', 'name' => 'Русский'],
            ['id' => 1, 'code' => 'uk', 'name' => 'Українська']
        ];
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