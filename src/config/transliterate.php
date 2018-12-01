<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default transliteration map
    |--------------------------------------------------------------------------
    |
    | This option specifies the transliteration map that will be used by default
    | if no explicit one will be provided during Transliteration::make() call.
    |
    | Supported: "common", "gost2000"
    |
    */
    'map' => 'common',

    /*
    |--------------------------------------------------------------------------
    | Custom transliteration maps
    |--------------------------------------------------------------------------
    |
    | You can create your custom transliteration maps or even override default.
    | Each map must be defined as "name" => "/absolute/path/to/map.php".
    |
    */
    'maps' => [
//        'ukraine' => dirname(__DIR__) . '/app/path/to/maps/ukraine.php',
    ]
];
