<?php

require 'vendor/autoload.php';

use Niyko\Rocket\Console\Commands\Build;
use Niyko\Rocket\Console\Commands\Run;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Build());
$application->add(new Run());
$application->run();