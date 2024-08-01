<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Configuration;

final readonly class KernelConfiguration implements Configuration
{
    public function __construct(
        private bool   $logErrors,
        private bool   $logErrorDetails,
        private bool   $errorDetails,
        private bool   $useSingleEntrypoint,
        private string $endpoint
    )
    {
    }

    public function logErrors(): bool
    {
        return $this->logErrors;
    }

    public function logErrorDetails(): bool
    {
        return $this->logErrorDetails;
    }

    public function errorDetails(): bool
    {
        return $this->errorDetails;
    }

    public function useSingleEntrypoint(): bool
    {
        return $this->useSingleEntrypoint;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
}