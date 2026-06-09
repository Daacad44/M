<?php

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $action): void
    {
        $this->addRoute('GET', $path, $controller, $action);
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->addRoute('POST', $path, $controller, $action);
    }

    private function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = compact('method', 'path', 'controller', 'action');
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->callController($route['controller'], $route['action'], $matches);
                return;
            }
        }

        http_response_code(404);
        view('errors.404', [], 'main');
    }

    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function callController(string $controller, string $action, array $params = []): void
    {
        $class = $controller . 'Controller';
        $file = BASE_PATH . '/controllers/' . $class . '.php';

        if (!file_exists($file)) {
            throw new RuntimeException("Controller not found: {$class}");
        }

        require_once $file;
        $instance = new $class();

        if (!method_exists($instance, $action)) {
            throw new RuntimeException("Action not found: {$class}::{$action}");
        }

        call_user_func_array([$instance, $action], $params);
    }
}
