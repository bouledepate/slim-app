<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Routing;

final class Route
{
    public array $middlewares = [];

    private function __construct(
        public readonly array        $method,
        public readonly string       $pattern,
        public readonly array|string $callable
    )
    {
    }

    public static function get(string $pattern, array|string $callable): self
    {
        return new self(['GET'], $pattern, $callable);
    }

    public static function post(string $pattern, array|string $callable): self
    {
        return new self(['POST'], $pattern, $callable);
    }

    public static function map(array $method, string $pattern, array|string $callable): self
    {
        return new self($method, $pattern, $callable);
    }

    public function middlewares(...$middlewares): self
    {
        foreach ($middlewares as $middleware) {
            $this->middlewares[] = $middleware;
        }
        return $this;
    }
}