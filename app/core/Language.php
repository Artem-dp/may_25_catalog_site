<?php

namespace app\core;

use app\interfaces\LanguageAwareInterface;

class Language implements LanguageAwareInterface
{
    /**
     * Default language code
     */
    private const DEFAULT_LANGUAGE = 'uk';

    /**
     * Session key for storing current language
     */
    private const SESSION_KEY = 'language';

    /**
     * All available languages with their details
     * @var array
     */
    private static array $languages = [
        [
            'id' => 1,
            'code' => 'uk',
            'name' => 'Українська'
        ],
        [
            'id' => 2,
            'code' => 'en',
            'name' => 'English'
        ],
        [
            'id' => 3,
            'code' => 'ru',
            'name' => 'Русский'
        ]
    ];

    /**
     * Get all available languages
     * @return array Array of language codes ['uk', 'en', 'ru']
     */
    public static function getLanguages(): array
    {
        return array_column(self::$languages, 'code');
    }

    /**
     * Get all languages with full details
     * @return array Array of associative arrays with id, code, name
     */
    public static function getAllLanguagesDetails(): array
    {
        return self::$languages;
    }

    /**
     * Get the current active language
     * @return string Current language code ex. 'uk'
     */
    public static function getCurrentLanguage(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION[self::SESSION_KEY])) {
            return $_SESSION[self::SESSION_KEY];
        }

        return self::DEFAULT_LANGUAGE;
    }

    /**
     * Set the current active language to session
     * @param string $langCode Language code to set
     * @return void
     */
    public static function setLanguage(string $langCode): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        // Validate that language exists
        if (in_array($langCode, self::getLanguages())) {
            $_SESSION[self::SESSION_KEY] = $langCode;
        }
    }

    /**
     * Get language details by code
     * @param string $code Language code
     * @return array|null Language details or null if not found
     */
    public static function getLanguageByCode(string $code): ?array
    {
        foreach (self::$languages as $language) {
            if ($language['code'] === $code) {
                return $language;
            }
        }

        return null;
    }

    /**
     * Get language details by id
     * @param int $id Language id
     * @return array|null Language details or null if not found
     */
    public static function getLanguageById(int $id): ?array
    {
        foreach (self::$languages as $language) {
            if ($language['id'] === $id) {
                return $language;
            }
        }

        return null;
    }

    public static function getDefaultLanguage(): string
    {
        return self::DEFAULT_LANGUAGE;
    }
}