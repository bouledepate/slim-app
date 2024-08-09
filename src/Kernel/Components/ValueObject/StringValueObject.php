<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;

abstract class StringValueObject extends ValueObject
{
    public function __construct(?string $value)
    {
        $this->value = is_null($value) ? $value : u($value);
    }

    public function isEqual(ValueObject $object): bool
    {
        return $object instanceof StringValueObject && $this->getValue() === $object->getValue();
    }

    public function getValue(): ?string
    {
        return is_null($this->value) ? $this->value : $this->value->toString();
    }

    public function getUnicodeString(): UnicodeString
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->getValue();
    }
}