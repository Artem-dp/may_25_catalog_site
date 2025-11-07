<?php

namespace app\interfaces;

/**
 * Interface for base models with language support
 * Language is automatically determined by Language::getCurrentLanguage()
 */
interface ModelInterface
{
    /**
     * Find by ID with current language
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array;

    /**
     * Delete record and all translations
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

//    TODO: нужно по советоваться как правильнее сделать остальные методы с учетом мультиязычности
}