<?php

namespace Niyko\Rocket\Console;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;

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

    public static function renderIntro($input, $output){
        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('🌞 A static site generator written in PHP which uses Laravel\'s Blade template engine.');
        $output->writeln('');
        
        $commands_table_style = new TableStyle();
        $commands_table_style->setVerticalBorderChars(' ')->setHorizontalBorderChars(' ')->setDefaultCrossingChar(' ');

        $output->writeln('<fg=yellow>Usage:</>');

        $commands_table = new Table($output);
        $commands_table->setStyle($commands_table_style);
        $commands_table->addRow(['composer rocket <fg=green>[command]</>']);
        $commands_table->render();

        $output->writeln('<fg=yellow>Available commands:</>');

        $commands_table = new Table($output);
        $commands_table->setStyle($commands_table_style);
        $commands_table->addRow(['<fg=green>dev</>', wordwrap('Start a development server', 50, "\n", true)]);
        $commands_table->addRow(['<fg=green>build</>', wordwrap('Baking project production build', 50, "\n", true)]);
        $commands_table->addRow(['<fg=green>run</>', wordwrap('Start a production server with the build', 50, "\n", true)]);
        $commands_table->addRow(['<fg=green>create</>', wordwrap('Create necessary files for the project', 50, "\n", true)]);
        $commands_table->render();
    }
}