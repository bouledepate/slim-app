<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

abstract class FloatValueObject extends ValueObject
{
    public function __construct(?float $value)
    {
        $this->value = $value;
    }

    public function isEqual(ValueObject $object): bool
    {
        return $object instanceof FloatValueObject && $this->value === $object->getValue();
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function jsonSerialize(): ?float
    {
        return $this->getValue();
    }
}