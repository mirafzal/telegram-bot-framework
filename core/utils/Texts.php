<?php

namespace core\utils;

class Texts
{
    private static $words;

    public static function setup($lang)
    {
        $languageFileName = 'localization/' . $lang . '/strings.php';
        if (file_exists($languageFileName)) {
            self::$words = require $languageFileName;
        } else {
            die('Setup language files in localization folder!');
        }
    }

    public static function get($key, ...$args)
    {
        var_dump($args);
        if (isset(self::$words[$key])) {
            return vsprintf(self::$words[$key], $args);
        }
        return "'$key' no translation";
    }

}