<?php

namespace Niyko\Rocket\Console\Commands;

use Statix\Server\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends Command
{
    protected static $defaultName = 'run';

    protected function execute(InputInterface $input, OutputInterface $output){
        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🌈 Server is started, Go to the link (<href=http://localhost:3000>http://localhost:3000</>) to view the site.</>');
        $output->writeln('');

        Server::new()
            ->port('3000')
            ->output(function ($log) use ($output){
                $output->writeln($log);
            })->start();

        return Command::SUCCESS;
    }
}
