<?php

namespace SupremoCRM\Agenda\Core;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, string $action): void
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post(string $uri, string $action): void
    {
        self::$routes['POST'][$uri] = $action;
    }

    public static function dispatch(string $uri, string $method): void
    {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        if (isset(self::$routes[$method][$uri])) {
            $action = self::$routes[$method][$uri];
            self::execute($action, []);
            return;
        }

        foreach (self::$routes[$method] as $route => $action) {
            $pattern = preg_replace('/\{[a-z]+\}/', '([0-9]+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);
                self::execute($action, $matches);
                return;
            }
        }

        http_response_code(404);

        echo "404 - Página não encontrada";
    }

    private static function execute(string $action, array $params = []): void
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        if (is_string($action)) {
            [$controller, $method] = explode('@', $action);
            $controllerClass = "SupremoCRM\\Agenda\\Http\\Controllers\\" . $controller;

            if (class_exists($controllerClass)) {
                $instance = new $controllerClass();
                call_user_func_array([$instance, $method], $params);
            } else {
                echo "Controller {$controllerClass} não encontrado!";
            }
        }
    }
}
