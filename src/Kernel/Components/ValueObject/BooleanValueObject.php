<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

abstract class BooleanValueObject extends ValueObject
{
    public function __construct(?bool $value)
    {
        $this->value = $value;
    }

    public function toggle(): void
    {
        if ($this->value !== null) {
            $this->value = !$this->value;
        }
    }

    public function isEqual(ValueObject $object): bool
    {
        return $object instanceof BooleanValueObject && $this->value === $object->getValue();
    }

    public function getValue(): ?bool
    {
        return $this->value;
    }

    public function jsonSerialize(): ?bool
    {
        return $this->getValue();
    }
}