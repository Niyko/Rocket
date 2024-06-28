<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Console\Helper;
use Statix\Server\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Dev extends Command
{
    protected static $defaultName = 'dev';

    protected function execute(InputInterface $input, OutputInterface $output){
        $server_port = 3000;

        while(Helper::isPortOpen($server_port)){
            $server_port = $server_port+1;
        }

        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🌈 Development server is started, Go to the link (<href=http://localhost:'.$server_port.'>http://localhost:'.$server_port.'</>) to view the site.</>');
        $output->writeln('');

        Server::new()
            ->router(realpath('').'/index.php')
            ->port($server_port)
            ->output(function ($log) use ($output){
                $output->writeln($log);
            })->start();

        return Command::SUCCESS;
    }
}
