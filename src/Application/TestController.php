<?php

declare(strict_types=1);

namespace BDP\Application;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class TestController
{
    public function __construct(private ResponseFactoryInterface $factory)
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $currentTime = new DateTimeImmutable();

        $response = $this->factory->createResponse();
        $response->getBody()->write(json_encode([
            'current-time' => $currentTime->format(DateTimeInterface::RFC850)
        ]));

        return $response;
    }
}