<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Blade;
use Niyko\Rocket\Console\Helper;
use Niyko\Rocket\Rocket;
use PhpZip\Exception\ZipException;
use PhpZip\ZipFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Build extends Command
{
    protected static $defaultName = 'build';

    protected function execute(InputInterface $input, OutputInterface $output){
        include 'index.php';
        
        $file_system = new Filesystem();

        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v1.0</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🔥 Baking project production build.</>');

        if($file_system->exists('build')) $file_system->remove('build');
        $file_system->mkdir('build');

        $output->writeln('<fg=green>✅ Build folder is cleared and remade.</>');
        $output->writeln('⚙️ Rendering build files from views.');

        $page_objects = Rocket::$page_objects;
        $progress_bar = Helper::progressBar($output, count($page_objects));
        $progress_bar->start();

        foreach($page_objects as $page_object){
            $html = Blade::getHtml($page_object['view']);
            $file_system->dumpFile('build/'.$page_object['page'].'.html', $html);
            $progress_bar->advance();
        }

        $progress_bar->finish();

        sleep(1);

        $output->writeln('');
        $output->write("\033[1A");
        $output->write("\033[2K");
        $output->write("\033[1A");
        $output->write("\033[2K");
        $output->writeln('<fg=green>✅ Build completed successfully.</>');
        $output->writeln('⚙️ Compressing the build to a zip file.');

        $zip_file = new ZipFile();
        try{
            $zip_file->addDir('build')
                ->saveAsFile('build/build.zip')
                ->close();

            $output->write("\033[1A");
            $output->write("\033[2K");
            $output->writeln('<fg=green>✅ Zipping the build is completed.</>');
        }
        catch(ZipException $exception){
            $output->write("\033[1A");
            $output->write("\033[2K");
            $output->writeln('<fg=red>⛔️ Zipping method failed.</>');
        }
        finally{
            $zip_file->close();
        }

        $output->writeln('<fg=green>✅ Build is fully completed and available in the "build" directory.</>');

        return Command::SUCCESS;
    }
}
