<?php

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
    $file_real_path = realpath('assets/'.$path);
    
    return '/assets/'.$path.'?integrity='.filemtime($file_real_path);
}

function env($key){
    return $_ENV[$key];
}