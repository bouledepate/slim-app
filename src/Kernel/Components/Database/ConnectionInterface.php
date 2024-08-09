<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Database;

/** @template TConnection of object */
interface ConnectionInterface
{
    /**
     * Returns an instance of Connection. For example, Doctrine.
     *
     * @return TConnection Connection object
     */
    public function getConnection();
}