<?php

use Niyko\Rocket\Config;
use Niyko\Rocket\Helper;

function page($name, $parameters=[]){
    if(isset($GLOBALS['_rocket_routes'][$name])){
        $page_url = Helper::parseStringTemplate($GLOBALS['_rocket_routes'][$name], $parameters);

        if(Helper::isBuildInstance()){
            if($page_url=='/') return '/index.html';
            else return $page_url.'.html';
        }
        else return Helper::getBaseUrl().$page_url;
    }
}

function asset($path){
    $base_url = '';
    $file_real_path = realpath('assets/'.$path);
    
    if(Helper::isBuildInstance() && Config::get('build.baseUrl')!='') $base_url = Config::get('build.baseUrl');
    
    return $base_url.'/assets/'.$path.'?integrity='.filemtime($file_real_path);
}

function css($path, $attributes = [], $options = []){
    return Helper::getCSSOrJSAsHTML('css', $path, $attributes, $options);
}

function js($path, $attributes = [], $options = []){
    return Helper::getCSSOrJSAsHTML('js', $path, $attributes, $options);
}