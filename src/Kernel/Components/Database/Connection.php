<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Database;

/**
 * @extends ConnectionInterface<\Doctrine\DBAL\Connection>
 */
final readonly class Connection implements ConnectionInterface
{
    public function __construct(private object $connection)
    {
    }

    public function getConnection(): object
    {
        return $this->connection;
    }
}