<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Routing;

interface RouteProvider
{
    public function getRoutes(): array;
}