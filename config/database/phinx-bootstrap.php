<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use BDP\Kernel\Components\Environment\DotenvUploader;

call_user_func(function () {
    $environment = new DotenvUploader(dirname(__DIR__, 2));
    $environment->validate();
});