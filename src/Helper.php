<?php

namespace Niyko\Rocket;

use Defr\PhpMimeType\MimeType;
use StringTemplate\Engine;
use Symfony\Component\Filesystem\Filesystem;

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
        $page_path = parse_url($page_path, PHP_URL_PATH);

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

    public static function arrayToHtmlAttributes($array){
        $attributes = '';
        foreach($array as $key => $value){
            if(is_int($key)) $attributes .= htmlspecialchars($value).' ';
            else $attributes .= htmlspecialchars($key).'="'.htmlspecialchars($value).'" ';
        }

        return trim($attributes);
    }

    public static function getCSSOrJSAsHTML($type, $path, $attributes, $options){
        $base_url = '';
        $tag_content = '';
        $tag_attributes = $attributes;

        if($type=='css'){
            $tag_attributes['rel'] = 'stylesheet';
            $tag_attributes['type'] = 'text/css';
        }
        else{
            $tag_attributes['type'] = 'text/javascript';
        }

        if(Helper::isBuildInstance() && Config::get('build.baseUrl')!='') $base_url = Config::get('build.baseUrl');

        if(filter_var($path, FILTER_VALIDATE_URL)){
            if(Helper::isBuildInstance() && Config::get('build.downloadExternalAssets') && ($options['avoid_download'] ?? false)==false){
                $file_name = hash('md5', $path);
                $file_system = new Filesystem();

                if($type=='css') $file_name = $file_name.'.css';
                else $file_name = $file_name.'.js';

                if($file_system->exists('cache/external')) $file_system->remove('cache/external');
                $file_system->mkdir('cache/external');

                if(!$file_system->exists('cache/external/'.$file_name)){
                    $file_system->dumpFile('dist/assets/external/'.$file_name, file_get_contents($path));
                }
                
                if($type=='css') $tag_attributes['href'] = $base_url.'/assets/external/'.$file_name;
                else $tag_attributes['src'] = $base_url.'/assets/external/'.$file_name;
            }
            else {
                if($type=='css') $tag_attributes['href'] = $path;
                else $tag_attributes['src'] = $path;
            }
        }
        else {
            $real_path = realpath('assets/'.$path);

            if(Helper::isBuildInstance() && Config::get('build.appendAssets') && ($options['avoid_append'] ?? false)==true){
                $contents = file_get_contents($real_path);

                if($type=='css'){
                    return '<style>'.$contents.'</style>';
                }
                else{
                    return '<script type="text/javascript">'.$contents.'</script>';
                }
            }
            else {
                $url = $base_url.'/assets/'.$path.'?integrity='.filemtime($real_path);

                if($type=='css') $tag_attributes['href'] = $url;
                else $tag_attributes['src'] = $url;
            }
        }

        if($type=='css') return '<link '.Helper::arrayToHtmlAttributes($tag_attributes).'>';
        else return '<script '.Helper::arrayToHtmlAttributes($tag_attributes).'>'.$tag_content.'</script>';
    }
}