<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Console\Helper as ConsoleHelper;
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
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v'.ConsoleHelper::packageVersion().'</>');
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

        if($file_system->exists('composer.json')){
            self::addScriptToComposer($file_system);
            $output->writeln('<fg=green>✅ Script have been added to composer file.</>');
        }

        if(!$file_system->exists('views')){
            $file_system->mkdir('views');
            $file_system->copy(Helper::getPackagePath('templates/sample.blade.php.txt'), 'views/sample.blade.php');
            $output->writeln('<fg=green>✅ Sample views are created.</>');
        }

        if(!$file_system->exists('config.json')){
            $file_system->copy(Helper::getPackagePath('templates/config.json'), 'config.json');
            $output->writeln('<fg=green>✅ Config file is created.</>');
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

    private function addScriptToComposer($file_system){
        $script_command = 'php vendor/niyko/rocket/src/Console/Console.php --ansi';
        $composer_json = file_get_contents('composer.json');
        $composer_data = json_decode($composer_json, true);

        if(!isset($composer_data['scripts'])){
            $composer_data['scripts'] = [];
        }

        if(!isset($composer_data['scripts']['rocket']) || $composer_data['scripts']['rocket']!==$script_command){
            $composer_data['scripts']['rocket'] = $script_command;
        }

        if(isset($composer_data['autoload']) && empty($composer_data['autoload'])){
            $composer_data['autoload'] = (object) $composer_data['autoload'];
        }

        if(!isset($composer_data['config'])){
            $composer_data['config'] = [];
        }

        if(!isset($composer_data['config']['process-timeout']) || $composer_data['config']['process-timeout']!==$script_command){
            $composer_data['config']['process-timeout'] = 0;
        }

        $composer_json = json_encode($composer_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $file_system->dumpFile('composer.json', $composer_json);
    }
}
