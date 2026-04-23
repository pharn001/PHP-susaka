<?php

abstract class Controller {
    protected function render(string $view, array $data = [], string $layout = 'app'): void {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $path): void {
        header('Location: ' . $path);
        exit;
    }

    protected function json(array $payload, int $status = 200): void {
        ResponseHelper::send($payload, $status);
    }
}
