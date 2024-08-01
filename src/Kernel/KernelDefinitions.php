<?php

declare(strict_types=1);

namespace BDP\Kernel;

use BDP\Kernel\Components\Configuration\ConfigurationFactory;
use BDP\Kernel\Components\Configuration\ConfigurationType;
use BDP\Kernel\Components\Configuration\KernelConfiguration;
use BDP\Kernel\Components\Container\ContainerProvider;
use BDP\Kernel\Components\Routing\Entrypoint;
use BDP\Kernel\Components\Routing\EntrypointController;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;

use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;

final readonly class KernelDefinitions implements ContainerProvider
{
    public function getDefinitions(): array
    {
        return [
            ResponseFactoryInterface::class => create(Psr17Factory::class),
            ConfigurationFactory::class => autowire()->constructor($_ENV),
            KernelConfiguration::class => factory([ConfigurationFactory::class, 'collect'])
                ->parameter('type', ConfigurationType::Slim),
            Entrypoint::class => create(EntrypointController::class)->constructor(
                get(ResponseFactoryInterface::class)
            )
        ];
    }
}