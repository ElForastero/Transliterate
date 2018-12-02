<?php

namespace ElForastero\Transliterate;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Class Facade
 * @package ElForastero\Transliterate
 * @author Eugene Dzhumak <elforastero@ya.ru>
 * @version 2.0.0
 */
class Facade extends BaseFacade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'Transliteration';
    }
}