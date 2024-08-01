<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Routing;

final class Group
{
    /** @var array<int, Route|Group> */
    public array $routes;
    public array $middlewares = [];

    private function __construct(public readonly string $prefix)
    {
    }

    public static function prefix(string $path): self
    {
        return new self($path);
    }

    public function routes(Route|Group ...$routes): self
    {
        foreach ($routes as $route) {
            $this->routes[] = $route;
        }
        return $this;
    }

    public function middlewares(...$middlewares): self
    {
        foreach ($middlewares as $middleware) {
            $this->middlewares[] = $middleware;
        }
        return $this;
    }
}