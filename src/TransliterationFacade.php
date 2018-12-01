<?php

namespace ElForastero\Transliterate;

use Illuminate\Support\Facades\Facade;

/**
 * Class TransliterationFacade
 * @package ElForastero\Transliterate
 * @author Eugene Dzhumak <elforastero@ya.ru>
 * @version 2.0.0
 */
class TransliterationFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'Transliteration';
    }
}