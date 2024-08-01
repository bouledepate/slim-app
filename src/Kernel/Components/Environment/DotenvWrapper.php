<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Environment;

use Dotenv\Dotenv;
use Dotenv\Validator;

final readonly class DotenvWrapper
{
    public function __construct(private Dotenv $dotenv)
    {
    }

    final public function getDotenv(): Dotenv
    {
        return $this->dotenv;
    }

    public function required(Constant ...$variables): Validator
    {
        $variables = array_map(fn(Constant $constant) => $constant->name, $variables);
        return $this->getDotenv()->required($variables);
    }
}