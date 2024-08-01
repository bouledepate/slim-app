<?php

declare(strict_types=1);

namespace BDP\Application;

use BDP\Kernel\Components\Routing\Route;
use BDP\Kernel\Components\Routing\RouteProvider;

class TestRoutesProvider implements RouteProvider
{
    public function getRoutes(): array
    {
        return [
            Route::get('/test-route', TestController::class)
        ];
    }
}