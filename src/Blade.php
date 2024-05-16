<?php

namespace Niyko\Rocket;

use eftec\bladeone\BladeOne;

class Blade
{
    public static function getHtml($view){
        $views = 'views';
        $cache = 'cache';
        $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
        
        return $blade->run($view, []);
    }
}