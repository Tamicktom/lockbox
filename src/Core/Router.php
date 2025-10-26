<?php

namespace Tamicktom\Lockbox\Core;

use Closure;

class Router
{
    /** @var array<string, array<int, array{pattern:string, handler:mixed}>> */
    private array $routes = [];

    public function get(string $pattern, mixed $handler): self
    {
        return $this->add('GET', $pattern, $handler);
    }
    public function post(string $pattern, mixed $handler): self
    {
        return $this->add('POST', $pattern, $handler);
    }
    public function put(string $pattern, mixed $handler): self
    {
        return $this->add('PUT', $pattern, $handler);
    }
    public function patch(string $pattern, mixed $handler): self
    {
        return $this->add('PATCH', $pattern, $handler);
    }
    public function delete(string $pattern, mixed $handler): self
    {
        return $this->add('DELETE', $pattern, $handler);
    }

    public function add(string $method, string $pattern, mixed $handler): self
    {
        $method = strtoupper($method);
        $this->routes[$method][] = [
            'pattern' => $this->compilePattern($pattern),
            'handler' => $handler,
        ];
        return $this;
    }

    public function dispatch(Request $request): mixed
    {
        $methodRoutes = $this->routes[$request->method] ?? [];
        foreach ($methodRoutes as $route) {
            $matches = [];
            if (preg_match($route['pattern'], $request->path, $matches)) {
                $params = array_filter(
                    $matches,
                    fn($key) => !is_int($key),
                    ARRAY_FILTER_USE_KEY
                );
                return $this->invokeHandler($route['handler'], $request, $params);
            }
        }
        return null;
    }

    private function compilePattern(string $pattern): string
    {
        $pattern = rtrim($pattern, '/') === '' ? '/' : rtrim($pattern, '/');
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern) ?? $pattern;
        return '#^' . $regex . '$#';
    }

    /**
     * Summary of invokeHandler
     * @param mixed $handler
     * @param Request $request
     * @param array<string, string> $params
     * @return mixed
     * @throws \InvalidArgumentException
     */
    private function invokeHandler(mixed $handler, Request $request, array $params): mixed
    {
        if ($handler instanceof Closure) {
            return $handler($request, $params);
        }
        if (is_array($handler) && count($handler) === 2 && is_string($handler[0])) {
            $className = $handler[0];
            $method = (string) $handler[1];
            $instance = new $className();
            return $instance->$method($request, $params);
        }
        if (is_callable($handler)) {
            return $handler($request, $params);
        }
        throw new \InvalidArgumentException('Invalid route handler');
    }
}
