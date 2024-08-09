<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Database;

/**
 * @property-read ConnectionInterface<\Doctrine\DBAL\Connection> $connection
 */
abstract class AbstractRepository
{
    public function __construct(protected ConnectionInterface $connection)
    {
    }
}