<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Environment;

enum Constant
{
    case LOG_ERRORS;
    case LOG_ERROR_DETAILS;
    case ERROR_DETAILS;
    case USE_SINGLE_ENTRYPOINT;
    case ENDPOINT;
}