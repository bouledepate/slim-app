<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Environment;

use Dotenv\Dotenv;

final readonly class DotenvUploader
{
    private DotenvWrapper $env;

    public function __construct()
    {
        $this->env = new DotenvWrapper(Dotenv::createImmutable(paths: $this->getPaths()));
        $this->env->getDotenv()->load();
    }

    public function validate(): void
    {
        $this->env->required(
            Constant::LOG_ERRORS,
            Constant::LOG_ERROR_DETAILS,
            Constant::ERROR_DETAILS,
            Constant::USE_SINGLE_ENTRYPOINT
        )->isBoolean();

        $this->env->required(Constant::ENDPOINT)->notEmpty();

        $this->env->required(
            Constant::DATABASE_HOST,
            Constant::DATABASE_NAME,
            Constant::DATABASE_USER,
            Constant::DATABASE_PASSWORD,
            Constant::DATABASE_PORT,
        )->notEmpty();
    }

    private function getPaths(): array
    {
        return [
            dirname(__DIR__, 4),
        ];
    }
}