<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Configuration;

use BDP\Kernel\Components\Environment\Constant;

final readonly class ConfigurationFactory
{
    public function __construct(private array $environment)
    {
    }

    public function collect(ConfigurationType $type): Configuration
    {
        return match ($type) {
            ConfigurationType::Slim => $this->getSlimConfiguration(),
        };
    }

    public function getValue(Constant $name, mixed $default = null): mixed
    {
        if (array_key_exists($name->name, $this->environment)) {
            return $this->environment[$name->name];
        }
        return $default;
    }

    private function getSlimConfiguration(): KernelConfiguration
    {
        return new KernelConfiguration(
            logErrors: (bool)$this->getValue(Constant::LOG_ERRORS, false),
            logErrorDetails: (bool)$this->getValue(Constant::LOG_ERROR_DETAILS, false),
            errorDetails: (bool)$this->getValue(Constant::ERROR_DETAILS, false),
            useSingleEntrypoint: (bool)$this->getValue(Constant::USE_SINGLE_ENTRYPOINT, true),
            endpoint: $this->getValue(Constant::ENDPOINT, '/api')
        );
    }
}