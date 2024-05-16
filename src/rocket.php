<?php

namespace Niyko\Rocket;

use Spatie\Ignition\Ignition;

class Rocket
{
    public static $page_objects;

    public static function init(){
        Ignition::make()
            ->setTheme('dark')
            ->register();
    }

    public static function page($page, $view){
        self::$page_objects[] = [
            'page' => $page,
            'view' => $view
        ];
    }

    public static function start(){
        if(php_sapi_name()!='cli'){
            $current_page = Helper::getCurrentPage();

            if(!$current_page){
                echo Helper::get404PageHtml();

                exit();
            }
            else{
                $page_object = Helper::getRegisteredPageObject(self::$page_objects, $current_page);

                if(!$page_object){
                    echo Helper::get404PageHtml();

                    exit();
                }
                else{
                    $html = Blade::getHtml($page_object['view']);
                    
                    echo $html;

                    exit();
                }
            }
        }
    }
}