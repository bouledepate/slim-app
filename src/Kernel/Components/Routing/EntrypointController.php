<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Routing;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final readonly class EntrypointController implements Entrypoint
{
    public function __construct(private ResponseFactoryInterface $responseFactory)
    {
    }

    public function __invoke(): ResponseInterface
    {
        return $this->responseFactory->createResponse(204);
    }
}