<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

use BDP\Kernel\Components\Environment\Constant;
use ReflectionClass;
use ReflectionException;

abstract readonly class AbstractEnvConfig implements EnvConfig
{
    /** @throws ReflectionException */
    public static function collectFrom(array $data): EnvConfig
    {
        $reflection = new ReflectionClass(static::class);
        $instance = $reflection->newInstanceWithoutConstructor();

        $constantMap = $instance->constantMap();
        foreach ($reflection->getProperties() as $property) {
            /** @var Constant $constant */
            $constant = $constantMap[$property->getName()] ?? null;
            if ($constant === null) {
                $value = null;
            } else {
                $value = $data[$constant->name] ?? null;
            }
            $property->setValue($instance, $value);
        }

        return $instance;
    }

    abstract protected function constantMap(): array;
}