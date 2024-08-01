<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Exception;

use Throwable;

final class ShutdownHandler
{
    public static function handleException(Throwable $exception): never
    {
        header('Content-Type: application/json', true, 500);
        $response = self::formatException($exception);
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
        exit;
    }

    private static function formatException(Throwable $exception): array
    {
        return [
            'error' => [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]
        ];
    }
}