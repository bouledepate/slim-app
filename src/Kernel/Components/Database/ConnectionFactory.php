<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Database;

use Doctrine\DBAL\DriverManager;

final readonly class ConnectionFactory
{
    public function __construct(private ConnectionConfig $config)
    {
    }

    public function establish(): ConnectionInterface
    {
        return new Connection(connection: DriverManager::getConnection([
            'driver' => 'pdo_pgsql',
            'host' => $this->config->getHostname(),
            'port' => $this->config->getPort(),
            'dbname' => $this->config->getDatabase(),
            'user' => $this->config->getUsername(),
            'password' => $this->config->getPassword(),
            'charset' => 'utf8',
        ]));
    }
}