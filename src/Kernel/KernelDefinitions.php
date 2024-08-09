<?php

declare(strict_types=1);

namespace BDP\Kernel;

use BDP\Kernel\Components\Config\ConfigType;
use BDP\Kernel\Components\Config\EnvConfigFactory;
use BDP\Kernel\Components\Container\ContainerProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use function DI\autowire;
use function DI\create;
use function DI\factory;

final readonly class KernelDefinitions implements ContainerProvider
{
    public function getDefinitions(): array
    {
        $definitions = [
            ResponseFactoryInterface::class => create(Psr17Factory::class),
            EnvConfigFactory::class => autowire()->constructor($_ENV)
        ];
        return array_merge($definitions, $this->configurations());
    }

    private function configurations(): array
    {
        $configs = [KernelConfig::class];
        $instances = array_map(
            fn(ConfigType $type) => factory([EnvConfigFactory::class, 'produce'])->parameter('type', $type),
            ConfigType::cases()
        );
        return array_combine($configs, $instances);
    }
}