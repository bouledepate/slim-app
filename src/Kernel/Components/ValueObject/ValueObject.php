<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

use JsonSerializable;

abstract class ValueObject implements JsonSerializable
{
    protected mixed $value;

    public abstract function isEqual(ValueObject $object): bool;

    abstract public function getValue(): mixed;

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public function isNull(): bool
    {
        return is_null($this->value);
    }
}