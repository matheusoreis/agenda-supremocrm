<?php

namespace SupremoCRM\Agenda\Core;

use Closure;

/**
 * Gerenciador de rotas
 * 
 * Responsável por registrar e direcionar as requisições HTTP
 * para os controllers e métodos.
 */
class Router
{
    private static array $routes = [];

    /**
     * Registra uma rota GET.
     * 
     * @param string $uri A URI da rota
     * @param string|Closure $action Ação a ser executada:
     *        - String no formato "Controller@method"
     *        - Closure para rotas simples
     * 
     * @return void
     */
    public static function get(string $uri, string|Closure $action): void
    {
        self::$routes['GET'][$uri] = $action;
    }

    /**
     * Registra uma rota POST,
     * 
     * @param string $uri A URI da rota
     * @param string|Closure $action Ação a ser executada:
     *        - String no formato "Controller@method"
     *        - Closure para rotas simples
     * 
     * @return void
     */
    public static function post(string $uri, string|Closure $action): void
    {
        self::$routes['POST'][$uri] = $action;
    }

    /**
     * Dispara a rota correspondente à requisição atual.
     * 
     * Processa a URI e método HTTP, encontra a rota correspondente
     * e executa a ação associada. Suporta parâmetros dinâmicos
     * na URL.
     * 
     * @param string $uri A URI da requisição
     * @param string $method O método HTTP
     * 
     * @return void
     */
    public static function dispatch(string $uri, string $method): void
    {
        // Remove a barra inicial e final da URI para normalização
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        // Verifica se existe uma rota exata para a URI e método
        if (isset(self::$routes[$method][$uri])) {
            $action = self::$routes[$method][$uri];
            self::execute($action, []);
            return;
        }

        // Verifica rotas com parâmetros dinâmicos
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

    /**
     * Executa a ação de uma rota.
     * 
     * Suporta dois tipos de ação:
     * 1. Closure: executa a função diretamente
     * 2. String "Controller@method": instancia o controller e chama o método
     * 
     * @param string|Closure $action Ação a ser executada
     * @param array $params Parâmetros a serem passados para a ação
     * 
     * @return void
     */
    private static function execute(string|Closure $action, array $params = []): void
    {
        // Ação é uma função anônima
        if ($action instanceof Closure) {
            call_user_func_array($action, $params);
            return;
        }

        // É uma string no formato "Controller@method"
        [$controller, $method] = explode('@', $action);
        // Constrói o nome completo da classe do controller.
        $controllerClass = "SupremoCRM\\Agenda\\Http\\Controllers\\" . $controller;

        if (class_exists($controllerClass)) {
            $instance = new $controllerClass();
            call_user_func_array([$instance, $method], $params);
        } else {
            echo "Controller {$controllerClass} não encontrado!";
        }
    }
}
