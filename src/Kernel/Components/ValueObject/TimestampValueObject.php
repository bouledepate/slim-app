<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

abstract class TimestampValueObject extends ValueObject
{
    protected const string FORMAT = 'Y-m-d H:i:s';
    protected ?DateTimeInterface $time = null;


    public function __construct(int|string|null $value = null)
    {
        if (is_string($value)) {
            $value = strtotime($value);
        }
        $this->value = $value;
        try {
            $this->time = $value ? new DateTimeImmutable(date(TimestampValueObject::FORMAT, $value)) : null;
        } catch (Throwable) {
            $this->time = null;
        }
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function getDatetime(): ?DateTimeInterface
    {
        return $this->time;
    }

    public function isEqual(ValueObject $object): bool
    {
        return $object instanceof TimestampValueObject && $object->getValue() === $this->value;
    }

    public function isEqualDate(DateTimeInterface $time): bool
    {
        return $this->value === $time->getTimestamp();
    }

    public function jsonSerialize(): ?int
    {
        return $this->getValue();
    }
}