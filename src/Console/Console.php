<?php

require 'vendor/autoload.php';

use Niyko\Rocket\Console\Commands\Build;
use Niyko\Rocket\Console\Commands\Create;
use Niyko\Rocket\Console\Commands\Dev;
use Niyko\Rocket\Console\Commands\Help;
use Niyko\Rocket\Console\Commands\Intro;
use Niyko\Rocket\Console\Commands\Run;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Intro());
$application->add(new Help());
$application->add(new Create());
$application->add(new Run());
$application->add(new Dev());
$application->add(new Build());
$application->run();