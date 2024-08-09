<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\ValueObject;

use Ds\Vector;
use InvalidArgumentException;

abstract class Collection implements \Iterator, \Countable, \JsonSerializable
{
    private int $position = 0;
    private Vector $collection;

    public function __construct(array $collection = [], bool $safe = true)
    {
        $this->collect($collection, $safe);
    }

    abstract function typeOf(): string;

    private function collect(array $items, bool $safe): void
    {
        $this->collection = new Vector();
        $expectedType = $this->typeOf();

        foreach ($items as $item) {
            if ($item instanceof $expectedType) {
                $this->collection->push($item);
            } else {
                if (false === $safe) {
                    $type = gettype($item);
                    throw new InvalidArgumentException("Invalid collection item. Expected: {$expectedType}, got {$type}.");
                }
            }
        }
    }

    public function jsonSerialize(): array
    {
        return $this->getArray();
    }

    public function getArray(): array
    {
        return $this->collection->toArray();
    }

    public function current(): mixed
    {
        return $this->collection->get($this->position);
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return $this->collection->offsetExists($this->position);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return $this->collection->count();
    }
}