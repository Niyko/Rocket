<?php

namespace Niyko\Rocket;

use Symfony\Component\Filesystem\Filesystem;

class Config
{
    public static $default = [
        'build.baseUrl' => '',
        'build.minifyHtml' => false,
        'build.minifyAssets' => false,
        'build.appendAssets' => false,
        'build.downloadExternalAssets' => false
    ];

    public static function get($key){
        return $GLOBALS['_rocket_config'][$key];
    }

    public static function getRenderedConfigs(){
        $file_system = new Filesystem();

        if($file_system->exists('config.json')){
            $user_config = json_decode(file_get_contents('config.json'), true);
            $configs = self::$default;

            foreach($configs as $key => $value){
                if(isset($user_config[$key])){
                    $configs[$key] = $user_config[$key];
                }
            }

            return $configs;
        }
        else return self::$default;
    }
}