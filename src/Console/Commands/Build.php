<?php

namespace Niyko\Rocket\Console\Commands;

use Niyko\Rocket\Blade;
use Niyko\Rocket\Config;
use Niyko\Rocket\Console\Helper;
use Niyko\Rocket\Minify;
use PhpZip\Exception\ZipException;
use PhpZip\ZipFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Build extends Command
{
    protected static $defaultName = 'build';

    protected function execute(InputInterface $input, OutputInterface $output){
        include 'index.php';
        
        $file_system = new Filesystem();

        $output->writeln('');
        $output->writeln('<fg=#ef4444;options=bold>🚀 Rocket Framework</> <fg=white;options=bold>• v'.Helper::packageVersion().'</>');
        $output->writeln('<fg=white;options=bold>──────────────────────────</>');
        $output->writeln('<fg=yellow>🔥 Baking project production build.</>');
        $output->writeln('');

        if($file_system->exists('cache/views')) $file_system->remove('cache/views');
        $file_system->mkdir('cache/views');

        if(!$file_system->exists('build')) $file_system->mkdir('build');

        if($file_system->exists('dist')) $file_system->remove('dist');
        $file_system->mkdir('dist');

        $output->writeln('<fg=green>✅ Build folder is cleared and remade.</>');

        if($file_system->exists('assets')){
            $file_system->mkdir('dist/assets');
            $file_system->mirror('assets', 'dist/assets');

            $output->writeln('<fg=green>✅ Asset folder is cleared and copied.</>');
        }

        $output->writeln('⚙️ Rendering build files from views.');

        $progress_bar = Helper::progressBar($output, count($GLOBALS['_rocket_pages']));
        $progress_bar->start();

        foreach($GLOBALS['_rocket_pages'] as $path => $page){
            $html = Blade::getHtml($page['view']['path'], $page['view']['parameters']);
            if(Config::get('build.minifyHtml')) $html = Minify::html($html);

            if($path=='/'){
                $file_name = 'index.html';
                $file_path = '';
            }
            else{
                $path_splits = explode('/', $path);
                $file_name = end($path_splits);
                $file_name = $file_name.'.html';
                array_pop($path_splits);
                $file_path = implode('/', $path_splits);
            }

            $file_system->mkdir('dist'.$file_path);
            $file_system->dumpFile('dist'.$file_path.'/'.$file_name, $html);
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

        if(Config::get('build.minifyAssets')){
            $output->writeln('⚙️ Minifying the build css and js files.');

            $build_file_finder = new Finder();
            $build_file_finder->files()->in('dist')->name('*.js')->name('*.css');

            $progress_bar = Helper::progressBar($output, count($build_file_finder));
            $progress_bar->start();

            foreach($build_file_finder as $file){
                $file_path = $file->getPath();
                $file_real_path = $file->getRealPath();
                $file_content = file_get_contents($file_real_path);

                if($file->getExtension()=='css'){
                    $file_content = Minify::css($file_content);
                }
                else{
                    $file_content = Minify::js($file_content);
                }
    
                $file_system->remove($file_real_path);
                $file_system->dumpFile($file_real_path, $file_content);

                $progress_bar->advance();
            }

            $progress_bar->finish();

            sleep(1);

            $output->writeln('');
            $output->write("\033[1A");
            $output->write("\033[2K");

            $output->write("\033[1A");
            $output->write("\033[2K");
            $output->writeln('<fg=green>✅ Minification completed successfully.</>');
        }

        $output->writeln('⚙️ Compressing the build to a zip file.');

        $zip_file = new ZipFile();
        try{
            $zip_file->addDirRecursive('dist')
                ->saveAsFile('build/build-'.time().'.zip')
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

        $output->writeln('');
        $output->writeln('<fg=cyan>🌀 Build zip file is fully completed and available in the <options=bold>"dist"</> directory.</>');
        $output->writeln('<fg=cyan>🌀 Zip file of the build is available in the <options=bold>"build"</> directory.</>');

        return Command::SUCCESS;
    }
}
