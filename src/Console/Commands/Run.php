<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Console\Helper;
use Statix\Server\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Run extends Command
{
    protected static $defaultName = 'run';

    protected function execute(InputInterface $input, OutputInterface $output){
        $server_port = 4000;

        while(Helper::isPortOpen($server_port)){
            $server_port = $server_port+1;
        }

        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🍕 Server server is started, Go to the link (<href=http://localhost:'.$server_port.'/index.html>http://localhost:'.$server_port.'/index.html</>) to view the site.</>');
        $output->writeln('');

        $file_system = new Filesystem();

        if($file_system->exists('dist')){
            Server::new()
                ->root(realpath('dist'))
                ->port($server_port)
                ->output(function ($log) use ($output){
                    $output->writeln($log);
                })->start();
        }
        else{
            $output->writeln('<fg=red>⛔️ Build is not created. Use the command <options=bold>composer rocket run</> to create the build first.</>');
        }

        return Command::SUCCESS;
    }
}
