<?php

class Router {
    private array $routes = [];
    private array $middlewares = [];

    public function get(string $path, $action, array $middlewares = []): void {
        $this->addRoute('GET', $path, $action, $middlewares);
    }

    public function post(string $path, $action, array $middlewares = []): void {
        $this->addRoute('POST', $path, $action, $middlewares);
    }

    public function put(string $path, $action, array $middlewares = []): void {
        $this->addRoute('PUT', $path, $action, $middlewares);
    }

    public function patch(string $path, $action, array $middlewares = []): void {
        $this->addRoute('PATCH', $path, $action, $middlewares);
    }

    public function delete(string $path, $action, array $middlewares = []): void {
        $this->addRoute('DELETE', $path, $action, $middlewares);
    }

    public function middleware(string $name, callable $callback): void {
        $this->middlewares[$name] = $callback;
    }

    public function dispatch(?string $method = null, ?string $uri = null): void {
        $method = strtoupper($method ?? $_SERVER['REQUEST_METHOD']);
        $uri = $this->normalizePath($uri ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        foreach ($this->routes[$method] ?? [] as $route) {
            $matches = $this->matchRoute($uri, $route['path']);
            if ($matches === null) {
                continue;
            }

            foreach ($route['middlewares'] as $middleware) {
                if (isset($this->middlewares[$middleware])) {
                    ($this->middlewares[$middleware])();
                }
            }

            $this->runAction($route['action'], $matches);
            return;
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['message' => '404 Not Found']);
    }

    private function addRoute(string $method, string $path, $action, array $middlewares = []): void {
        $this->routes[$method][] = [
            'path' => $this->normalizePath($path),
            'action' => $action,
            'middlewares' => $middlewares,
        ];
    }

    private function normalizePath(string $path): string {
        $path = str_replace('/index.php', '/', $path);

        if ($path === '' || $path === '/') {
            return '/';
        }

        return '/' . trim($path, '/');
    }

    private function matchRoute(string $uri, string $route): ?array {
        $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $uri, $matches)) {
            return null;
        }

        array_shift($matches);
        return $matches;
    }

    private function runAction($action, array $params): void {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        [$controller, $method] = explode('@', $action);
        $controllerPath = __DIR__ . '/../Controllers/' . $controller . '.php';

        if (is_file($controllerPath)) {
            require_once $controllerPath;
        }

        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $method], $params);
    }
}
