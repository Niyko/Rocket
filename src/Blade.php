<?php

namespace Niyko\Rocket;

use eftec\bladeone\BladeOne;

class Blade
{
    public static function getHtml($view, $parameters){
        $views = 'views';
        $cache = 'cache/views';
        $blade = new BladeOne($views, $cache, BladeOne::MODE_SLOW);

        $blade->directive('css', function ($expression){
            $parameters = [];
            eval("\$parameters = [$expression];");
            
            return css($parameters[0] ?? '', $parameters[1] ?? [], $parameters[2] ?? []);
        });

        $blade->directive('js', function ($expression){
            $parameters = [];
            eval("\$parameters = [$expression];");

            return js($parameters[0] ?? '', $parameters[1] ?? [], $parameters[2] ?? []);
        });
        
        return $blade->run($view, $parameters);
    }
}