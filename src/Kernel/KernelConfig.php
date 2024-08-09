<?php

declare(strict_types=1);

namespace BDP\Kernel;

use BDP\Kernel\Components\Config\AbstractEnvConfig;
use BDP\Kernel\Components\Environment\Constant;

final readonly class KernelConfig extends AbstractEnvConfig
{
    private ?bool $logErrors;
    private ?bool $logErrorDetails;
    private ?bool $errorDetails;
    private ?bool $useSingleEntrypoint;
    private ?string $endpoint;

    protected function constantMap(): array
    {
        return [
            'logErrors' => Constant::LOG_ERRORS,
            'logErrorDetails' => Constant::LOG_ERROR_DETAILS,
            'errorDetails' => Constant::ERROR_DETAILS,
            'useSingleEntrypoint' => Constant::USE_SINGLE_ENTRYPOINT,
            'endpoint' => Constant::ENDPOINT
        ];
    }

    public function isLogErrors(): bool
    {
        return $this->logErrors;
    }

    public function isErrorDetails(): bool
    {
        return $this->errorDetails;
    }

    public function isLogErrorDetails(): bool
    {
        return $this->logErrorDetails;
    }

    public function isUseSingleEntrypoint(): bool
    {
        return $this->useSingleEntrypoint;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
}