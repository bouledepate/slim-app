<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config;

enum ConfigType: int
{
    case Kernel = 0;
    case Database = 1;
}