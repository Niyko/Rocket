<?php

namespace Niyko\Rocket;

class Helper
{
    public static function getCurrentUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443)?'https://':'http://';
        $host = $_SERVER['HTTP_HOST'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $current_url = $protocol.$host.$request_uri;
        
        return $current_url;
    }

    public static function getCurrentPage(){
        $current_url = self::getCurrentUrl();
        $splited_url = explode('/', $current_url);

        if(count($splited_url)==0) return false;
        else{
            $page_name = end($splited_url);

            if($page_name=='') return 'index';
            else return $page_name;
        }
    }

    public static function getRegisteredPageObject($page_objects, $page_name){
        foreach($page_objects as $page_object){
            if($page_object['page']==$page_name){
                return $page_object;
            }
        }

        return false;
    }

    public static function get404PageHtml(){
        return file_get_contents(self::getPackagePath('templates/404.html'));
    }

    public static function getPackagePath($append_path=''){
        return 'vendor/niyko/rocket/'.$append_path;
    }
}