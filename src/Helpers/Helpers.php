<?php

if (!function_exists('render_component')) {
    function render_component(string $name, array $data = []): string
    {
        $componentPath = __DIR__ . "/../../resources/views/components/{$name}.php";

        if (!file_exists($componentPath)) {
            return "<!-- Component {$name} not found -->";
        }

        extract($data);

        ob_start();
        include $componentPath;
        return ob_get_clean();
    }
}

if (!function_exists('render_view')) {
    function render_view(string $name, array $data = []): string
    {
        $viewPath = __DIR__ . "/../../resources/views/pages/{$name}.php";

        if (!file_exists($viewPath)) {
            return "<!-- View {$name} not found -->";
        }

        extract($data);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}


if (!function_exists('fetch_api')) {
    function fetch_api(string $url): array|false
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
            'http' => [
                'timeout' => 30,
                'user_agent' => 'AgendaSupremoCRM/1.0',
            ]
        ]);

        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        return json_decode($response, true);
    }
}
