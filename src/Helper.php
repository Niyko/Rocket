<?php

namespace Niyko\Rocket;

use Defr\PhpMimeType\MimeType;
use StringTemplate\Engine;

class Helper
{
    public static function getCurrentUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443)?'https://':'http://';
        $host = $_SERVER['HTTP_HOST'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $current_url = $protocol.$host.$request_uri;
        
        return $current_url;
    }

    public static function getBaseUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443)?'https://':'http://';
        $host = $_SERVER['HTTP_HOST'];

        return $protocol.$host;
    }

    public static function getCurrentPagePath(){
        $current_url = self::getCurrentUrl();
        $base_url = self::getBaseUrl();
        $page_path = str_replace($base_url, '', $current_url);

        return $page_path;
    }

    public static function getRegisteredPageObject($page_objects, $page_name){
        foreach($page_objects as $page_object){
            if($page_object['page_name']==$page_name){
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

    public static function isBuildInstance(){
        return php_sapi_name()=='cli';
    }

    public static function parseStringTemplate($template, $parameters){
        $engine = new Engine();
        $string = $engine->render($template, $parameters);

        return $string;
    }

    public static function getFileContentType($path){
        $mime_type = MimeType::get($path);

        return $mime_type;
    }
}