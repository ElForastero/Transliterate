<?php

/** @noinspection PhpVoidFunctionResultUsedInspection */
return [
    /*
    |--------------------------------------------------------------------------
    | Default transliteration map
    |--------------------------------------------------------------------------
    |
    | This option specifies the transliteration map that will be used by default
    | if no explicit one will be provided during Transliteration::make() call.
    |
    */
    'default_map' => 'common',

    /*
    |--------------------------------------------------------------------------
    | Set default language
    |--------------------------------------------------------------------------
    | Language of transliterating text. Will be used unless no explicitly
    | provided into Transliteration::from().
    |
    */
    'default_lang' => 'ru',

    /*
    |--------------------------------------------------------------------------
    | Custom transliteration maps
    |--------------------------------------------------------------------------
    |
    | You can create your custom transliteration maps or even override default.
    | Each map must be defined as "lang_code" => ["map_name" => "/absolute/path/to/map.php"].
    |
    */
    'custom_maps' => [
//        'uk' => [
//            'common' => dirname(__DIR__) . '/app/path/to/maps/uk/common.php',
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Transformer callbacks
    |--------------------------------------------------------------------------
    |
    | It is possible to register your own transformer functions that will be
    | called on transliterated string. This is useful if you need to perform
    | the same actions on a result string every time.
    |
    | Since closures can't be serialized during "artisan config:cache" call,
    | use "\ElForastero\Transliterate\Closure::register"
    |
    */
    'transformers' => [
//        \ElForastero\Transliterate\Transformer::register(\Closure::fromCallable('trim'))
    ],

    /*
    |--------------------------------------------------------------------------
    | Remove accents
    |--------------------------------------------------------------------------
    |
    | Try to remove accents from letters already transliterated text.
    | This feature uses iconv function, which may doesn't work properly depending
    | on the installed libiconv realization.
    |
    | See http://php.net/manual/ru/intro.iconv.php
    |
    */
    'remove_accents' => true,
];
