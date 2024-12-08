<?php

namespace Niyko\Rocket;

use Dotenv\Dotenv;
use Spatie\Ignition\Ignition;

class Rocket
{
    public static function init(){
        $GLOBALS['_rocket_pages'] = [];
        
        $dotenv = Dotenv::createImmutable(getcwd());
        $dotenv->load();

        Ignition::make()
            ->setTheme('dark')
            ->register();
    }

    public static function page($name){
        return (new Page)::create($name);
    }

    public static function start(){
        if(!Helper::isBuildInstance()){
            $current_page_path = Helper::getCurrentPagePath();

            if(substr($current_page_path, 0, 8)==='/assets/'){
                $parsed_url = parse_url($current_page_path);
                $file_real_path = realpath(ltrim($parsed_url['path'], '/'));

                if(file_exists($file_real_path)){
                    header('Content-Type: '.Helper::getFileContentType($file_real_path));
                    readfile($file_real_path);

                    exit();
                }
                else{
                    echo Helper::get404PageHtml();

                    exit();
                }
            }
            else if(isset($GLOBALS['_rocket_pages'][$current_page_path])){
                $page = $GLOBALS['_rocket_pages'][$current_page_path];
                $html = Blade::getHtml($page['view']['path'], $page['view']['parameters']);

                echo $html;

                exit();
            }
            else {
                echo Helper::get404PageHtml();

                exit();
            }
        }
    }
}