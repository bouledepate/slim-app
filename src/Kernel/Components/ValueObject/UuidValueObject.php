<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

use Ramsey\Uuid\Uuid;

abstract class UuidValueObject extends StringValueObject
{
    public function __construct(?string $value = null, bool $autogenerate = false)
    {
        if ($autogenerate && $value === null) {
            $value = Uuid::uuid4()->toString();
        }
        parent::__construct($value);
    }

    public function isValid(): bool
    {
        return Uuid::isValid($this->getValue());
    }
}