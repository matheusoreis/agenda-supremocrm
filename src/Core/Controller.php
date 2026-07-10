<?php

namespace SupremoCRM\Agenda\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        ob_start();

        require __DIR__ . '/../../resources/views/' . $view . '.php';

        $content = ob_get_clean();

        require __DIR__ . '/../../resources/views/layouts/app.php';
    }
}
