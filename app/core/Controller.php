<?php

namespace app\core;

class Controller
{
    protected function render($view, $data = [], $layout = 'site/layouts/default_template')
    {

        extract($data);

        $viewPath = APP_PATH . '/resources/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: $viewPath");
        }

        $layoutPath = APP_PATH . '/resources/views/' . $layout . '.php';

        if (!file_exists($layoutPath)) {
            die("Layout not found: $layoutPath");
        }

        $viewFile = $viewPath;

        require $layoutPath;
    }
}