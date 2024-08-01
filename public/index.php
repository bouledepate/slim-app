<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use BDP\Kernel\Kernel;
use BDP\Kernel\Components\Exception\ShutdownHandler;

try {
    $application = Kernel::create();
    $application->run();
} catch (Throwable $exception) {
    ShutdownHandler::handleException($exception);
}