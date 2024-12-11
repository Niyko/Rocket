<?php

namespace Niyko\Rocket;

use voku\helper\HtmlMin;
use MatthiasMullie\Minify as Minifer;

class Minify
{
    public static function css($css){
        $css_minifier = new Minifer\CSS();
        $css_minifier->add($css);

        return $css_minifier->minify();
    }

    public static function js($js){
        $js_minifier = new Minifer\JS();
        $js_minifier->add($js);

        return $js_minifier->minify();
    }

    public static function html($html){
        preg_match_all('/<style\b[^>]*>(.*?)<\/style>/is', $html, $css_matches);
        foreach($css_matches[0] as $css){
            $css_minifier = new Minifer\CSS();
            $css_minifier->add($css);
            $minified_css = $css_minifier->minify();
            $html = str_replace($css, $minified_css, $html);
        }
    
        preg_match_all('/<script\b(?![^>]*\bsrc=)[^>]*>(.*?)<\/script>/is', $html, $js_matches);
        foreach($js_matches[0] as $js){
            $js_minifier = new Minifer\JS();
            $js_minifier->add($js);
            $minified_js = $js_minifier->minify();
            $html = str_replace($js, $minified_js, $html);
        }

        $html_min = new HtmlMin();
        $html = $html_min->minify($html);
    
        return $html;
    }
}