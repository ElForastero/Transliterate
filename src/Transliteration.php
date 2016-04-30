<?php
namespace ElForastero\Transliterate;

class Transliteration
{
    public static function make($string)
    {
        $convertedString = iconv('UTF8', 'ASCII//TRANSLIT', $string);
        return str_replace(' ', '-', $convertedString);
    }
}
