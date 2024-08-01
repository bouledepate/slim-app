<?php

declare(strict_types=1);

namespace BDP\Application;

use BDP\Kernel\Components\Container\ContainerProvider;

use function DI\autowire;

final readonly class TestDefinitions implements ContainerProvider
{
    public function getDefinitions(): array
    {
        return [
            TestController::class => autowire()
        ];
    }
}