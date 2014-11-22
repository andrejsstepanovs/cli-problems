<?php

include 'vendor/autoload.php';

use App\Service\Locator;

$config = include 'etc/config.php';

(new Locator($config))->getApplication()->run();
