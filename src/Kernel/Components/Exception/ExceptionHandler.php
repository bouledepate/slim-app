<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Exception;

use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler;
use Psr\Http\Message\ResponseInterface;


final class ExceptionHandler extends ErrorHandler
{
    protected function respond(): ResponseInterface
    {
        $statusCode = 400;
        $exception = $this->exception;
        $responseData = $this->getDefaultResponse();

        if ($exception instanceof HttpException) {
            $statusCode = $this->determineErrorCode();
        }

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write(json_encode($responseData, JSON_UNESCAPED_SLASHES));

        return $response->withHeader('Content-Type', 'application/json');
    }

    private function determineErrorCode(): int
    {
        return $this->exception->getCode();
    }

    private function determineErrorMessage(): string
    {
        return $this->exception->getMessage();
    }

    private function getDefaultResponse(): array
    {
        return [
            'error' => [
                'code' => $this->determineErrorCode(),
                'message' => $this->determineErrorMessage(),
            ]
        ];
    }

}