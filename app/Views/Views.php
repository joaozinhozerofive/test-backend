<?php

namespace Mvc\Views;

class Views
{
    public static function render(string $view, array $data = [])
    {
        $viewPath = __DIR__ . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View '{$viewPath}' não encontrada.");
        }

        extract($data);

        ob_start();	
        
        include $viewPath;

        echo ob_get_clean();
    }
}