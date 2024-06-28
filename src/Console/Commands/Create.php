<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Helper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Create extends Command
{
    protected static $defaultName = 'create';

    protected function execute(InputInterface $input, OutputInterface $output){
        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🍉 Creating the project with sample template.</>');
        $output->writeln('');

        $file_system = new Filesystem();

        if(!$file_system->exists('index.php')){
            $file_system->copy(Helper::getPackagePath('templates/index.php.txt'), 'index.php');
            $output->writeln('<fg=green>✅ Router file is created.</>');
        }

        if(!$file_system->exists('.gitignore')){
            $file_system->copy(Helper::getPackagePath('templates/.gitignore.txt'), '.gitignore');
            $output->writeln('<fg=green>✅ Git ignore file is created.</>');
        }

        if(!$file_system->exists('views')){
            $file_system->mkdir('views');
            $file_system->copy(Helper::getPackagePath('templates/sample.blade.php.txt'), 'views/sample.blade.php');
            $output->writeln('<fg=green>✅ Sample views are created.</>');
        }

        if(!$file_system->exists('assets')){
            $file_system->mkdir('assets');
            $file_system->mirror(Helper::getPackagePath('templates/css'), 'assets/css');
            $file_system->mirror(Helper::getPackagePath('templates/images'), 'assets/images');
            $output->writeln('<fg=green>✅ Sample assets are created.</>');
        }

        $output->writeln('<fg=green>✅ Project is created successfully.</>');
        $output->writeln('');
        $output->writeln('<fg=cyan>🌀 Run the command <options=bold>composer rocket dev</> to test the sample template.</>');

        return Command::SUCCESS;
    }
}
