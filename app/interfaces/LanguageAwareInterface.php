<?php

namespace app\interfaces;

/**
 * Interface for classes that work with languages
 */
interface LanguageAwareInterface
{
    /**
     * Get all available languages
     * @return array  ['uk', 'en', 'ru']
     */
    public static function getLanguages(): array;

    /**
     * Get the current active language
     *
     * @return string Current language code ex. 'uk'
     */
    public static function getCurrentLanguage(): string;

    /**
     * Set the current active language to session
     * @param string $langCode
     * @return void
     */
    public static function setLanguage(string $langCode): void;

}