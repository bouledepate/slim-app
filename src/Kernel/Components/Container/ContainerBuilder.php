<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Container;

use BDP\Kernel\Components\Routing\Entrypoint;
use BDP\Kernel\Components\Routing\EntrypointController;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use function DI\create;
use function DI\get;

final class ContainerBuilder
{
    private \DI\ContainerBuilder $builder;

    public function __construct()
    {
        $this->builder = new \DI\ContainerBuilder();
    }

    /**
     * @throws Exception
     */
    public function build(): ContainerInterface
    {
        $providers = $this->getProviders();
        foreach ($providers as $providerClass) {
            if ($this->isProviderValid($providerClass)) {
                try {
                    $provider = $this->getProvider($providerClass);
                    $this->builder->addDefinitions($provider->getDefinitions());
                } catch (ReflectionException) {
                    continue;
                }
            }
        }
        return $this->builder->build();
    }

    private function isProviderValid(string $provider): bool
    {
        return is_subclass_of($provider, ContainerProvider::class);
    }

    private function getProviders(): array
    {
        return require_once dirname(__DIR__, 4) . '/config/definitions.php';
    }

    /** @throws ReflectionException */
    private function getProvider(string $providerClass): ContainerProvider
    {
        $reflection = new ReflectionClass($providerClass);
        return $reflection->newInstanceWithoutConstructor();
    }
}