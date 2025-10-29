<?php

namespace Seymon\AngryPurpleTiger;

class Generate {

    public function animalHash($input, $style = "titlecase", $separator = " "){
        $animals = require __DIR__.'/animals.php';
        $adjectives = require __DIR__.'/adjectives.php';
        $colors = require __DIR__.'/colors.php';

        $hexdigest = md5($input);
        $pairs = str_split($hexdigest, 2);
        $bytes = array_map('hexdec', $pairs);
        $compressed = $this->compress($bytes, 3);

        $adjective = $adjectives[$compressed[0]];
        $color = $colors[$compressed[1]];
        $animal = $animals[$compressed[2]];

        return $this->format([$adjective, $color, $animal], $style, $separator);
    }

    private function toStyled($words, $style){
        switch($style){
            case("titlecase"):
                return array_map(function($word){
                    return ucfirst($word);
                }, $words);
            break;
            case("lowercase"):
                return array_map(function($word){
                    return strtolower($word);
                }, $words);
            break;
            case("uppercase"):
                return array_map(function($word){
                    return strtoupper($word);
                }, $words);
            break;
            default:
                throw new \Exception('Unknown style');
            break;
        }
    }

    private function format($words, $style, $separator) {
        $styledWords = $this->toStyled($words, $style);
        return implode($separator, $styledWords);
    }

    private function compress($bytes, $target) {
        $length = count($bytes);
        if ($target > $length) {
            throw new \Exception('Fewer input bytes than requested output');
        }
    
        $segSize = floor($length / $target);
    
        $segments = [];
        for ($i = 0; $i < $segSize * $target; $i += $segSize) {
            $segments[] = array_slice($bytes, $i, $segSize);
        }
    
        $lastSeg = $segments[count($segments) - 1];
        $segments[count($segments) - 1] = array_merge($lastSeg, array_slice($bytes, $target * $segSize));
    
        $checksums = array_map(function ($segment) {
            return array_reduce($segment, function ($acc, $curr) {
                return $acc ^ $curr;
            });
        }, $segments);
    
        return $checksums;
    }

}
?>