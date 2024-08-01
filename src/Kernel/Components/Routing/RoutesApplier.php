<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Routing;

use ReflectionClass;
use ReflectionException;
use Slim\Interfaces\RouteCollectorProxyInterface;

final readonly class RoutesApplier
{
    public function __construct(private RouteCollectorProxyInterface $collector)
    {
    }

    public function apply(): void
    {
        $providers = $this->getProviders();
        foreach ($providers as $providerClass) {
            if ($this->isProviderValid($providerClass)) {
                try {
                    $provider = $this->getProvider($providerClass);
                    $this->process(...$provider->getRoutes());
                } catch (ReflectionException) {
                    continue;
                }
            }
        }
    }

    private function process(Route|Group ...$routes): void
    {
        foreach ($routes as $item) {
            match ($item::class) {
                Route::class => $this->applyRoute($item),
                Group::class => $this->applyGroup($item)
            };
        }
    }

    private function applyRoute(Route $route): void
    {
        $r = $this->collector->map($route->method, $route->pattern, $route->callable);
        array_walk($route->middlewares, fn($middleware) => $r->add($middleware));
    }

    private function applyGroup(Group $group): void
    {
        $g = $this->collector->group(
            pattern: $group->prefix,
            callable: fn(RouteCollectorProxyInterface $proxy) => $this->process(...$group->routes)
        );
        array_walk($group->middlewares, fn ($middleware) => $g->add($middleware));
    }

    private function isProviderValid(string $providerClass): bool
    {
        return is_subclass_of($providerClass, RouteProvider::class);
    }

    private function getProviders(): array
    {
        return require_once dirname(__DIR__, 4) . '/config/routes.php';
    }

    /** @throws ReflectionException */
    private function getProvider(string $providerClass): RouteProvider
    {
        $reflection = new ReflectionClass($providerClass);
        return $reflection->newInstanceWithoutConstructor();
    }
}