<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Console\Helper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Help extends Command
{
    protected static $defaultName = 'help';

    protected function execute(InputInterface $input, OutputInterface $output){
        Helper::renderIntro($input, $output);

        return Command::SUCCESS;
    }
}