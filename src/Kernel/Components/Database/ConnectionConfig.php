<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Database;

use BDP\Kernel\Components\Config\AbstractEnvConfig;
use BDP\Kernel\Components\Environment\Constant;

final readonly class ConnectionConfig extends AbstractEnvConfig
{
    private string $hostname;
    private string $database;
    private string $username;
    private string $password;
    private int $port;

    protected function constantMap(): array
    {
        return [
            'hostname' => Constant::DATABASE_HOST,
            'database' => Constant::DATABASE_NAME,
            'username' => Constant::DATABASE_USER,
            'password' => Constant::DATABASE_PASSWORD,
            'port' => Constant::DATABASE_PORT,
        ];
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }
}