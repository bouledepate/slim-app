<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

use BDP\Kernel\Components\Database\ConnectionConfig;
use BDP\Kernel\KernelConfig;
use ReflectionException;

final readonly class EnvConfigFactory
{
    public function __construct(private array $environment = [])
    {
    }

    /** @throws ReflectionException */
    public function produce(ConfigType $type): EnvConfig
    {
        return match ($type) {
            ConfigType::Kernel => KernelConfig::collectFrom($this->environment),
            ConfigType::Database => ConnectionConfig::collectFrom($this->environment)
        };
    }
}