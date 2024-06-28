<?php

namespace Niyko\Rocket;

class Page
{
    public static $arguments;

    public static function create($name){
        $page = (new static);

        $page::$arguments = [
            'name' => $name
        ];

        return $page;
    }

    public function url($path, $parameters=[]){
        $parsed_path = Helper::parseStringTemplate($path, $parameters);

        self::$arguments['url'] = $parsed_path;
        self::$arguments['raw_url'] = $path;

        return $this;
    }

    public function view($path, $parameters=[]){
        self::$arguments['view'] = [];
        self::$arguments['view']['path'] = $path;
        self::$arguments['view']['parameters'] = $parameters;

        return $this;
    }

    public function add(){
        $GLOBALS['_rocket_pages'][self::$arguments['url']] = self::$arguments;
        $GLOBALS['_rocket_routes'][self::$arguments['name']] = self::$arguments['raw_url'];
    }
}