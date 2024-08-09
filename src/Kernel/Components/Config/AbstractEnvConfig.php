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
                if ($value !== null) {
                    $type = $property->getType()->getName();
                    $value = self::typecast($value, $type);
                }
            }
            $property->setValue($instance, $value);
        }

        return $instance;
    }

    abstract protected function constantMap(): array;

    private static function typecast(mixed $value, string $type): string|int|bool|float
    {
        return match ($type) {
            'string' => (string)$value,
            'int' => intval($value),
            'bool' => boolval($value),
            'float' => floatval($value),
        };
    }
}