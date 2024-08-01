<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Container;

interface ContainerProvider
{
    public function getDefinitions(): array;
}