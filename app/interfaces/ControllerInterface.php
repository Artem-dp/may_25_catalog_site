<?php

namespace app\interfaces;

/**
 * Interface for base controllers
 */
interface ControllerInterface
{
    /**
     * Render template
     *
     * @param string $template
     * @param array $data
     * @param string $layout
     * @return void
     */
    public function render(string $template, array $data = [], string $layout = 'default'): void;

    /**
     *
     * @param string $url
     * @param int $statusCode
     * @return void
     */
    public function redirect(string $url, int $statusCode = 302): void;

}