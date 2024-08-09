<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

abstract class IntegerValueObject extends ValueObject
{
    public function __construct(?int $value)
    {
        $this->value = $value;
    }

    public function isEqual(ValueObject $object): bool
    {
        return $object instanceof IntegerValueObject && $this->value === $object->getValue();
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function jsonSerialize(): ?int
    {
        return $this->getValue();
    }
}