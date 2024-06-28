<?php

namespace Niyko\Rocket\Console;

use Symfony\Component\Console\Helper\ProgressBar;

class Helper
{
    public static function progressBar($output, $total){
        $progress_bar = new ProgressBar($output, $total);
        $progress_bar->setBarCharacter('<fg=green>▬</>');
        $progress_bar->setEmptyBarCharacter('<fg=gray>▬</>');
        $progress_bar->setProgressCharacter('<fg=green>▬</>');
        $progress_bar->setBarWidth(50);

        return $progress_bar;
    }

    public static function isPortOpen($port){
        $socket = @fsockopen('localhost', $port);

        return $socket==true;
    }
}