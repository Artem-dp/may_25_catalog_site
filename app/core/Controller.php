<?php

namespace app\core;

class Controller
{
    // Метод для рендера страниц
    protected function render($view, $data = [])
    {
        // Формируем путь к шаблону
        $viewPath = __DIR__ . '/../../resources/views/' . $view . '.php';

        // Проверяем, существует ли файл шаблона
        if (!file_exists($viewPath)) {
            die('View "' . $view . '" not found.');
        }

        // Превращаем элементы массива в переменные:
        // ['title' => 'Текст'] станет $title = 'Текст'
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        // Подключаем шаблон
        require $viewPath;
    }
}