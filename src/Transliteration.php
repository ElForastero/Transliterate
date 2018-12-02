<?php

namespace ElForastero\Transliterate;

/**
 * Feel free to change it.
 * Either by pull request or forking.
 *
 * Class Transliteration
 * @package ElForastero\Transliterate
 * @author Eugene Dzhumak <elforastero@ya.ru>
 * @version 2.0.0
 */
class Transliteration
{
    /**
     * Transliterate the given string
     *
     * @param string $string Text to be transliterated
     * @param string $map Map to be used during transliteration
     * @return string
     */
    public static function make(string $string, string $map = null): string
    {
        $map = self::getMap($map);
        $chars = implode('', array_keys($map));
        $clearedString = preg_replace("/[^\\s\\p{P}\\w${chars}]/iu", '', $string);
        $transliterated = str_replace(array_keys($map), array_values($map), $clearedString);

        return self::applyTransformers($transliterated);
    }

    /**
     * Get map array according to config file
     *
     * @param string|null $map
     * @return array
     */
    private static function getMap(string $map = null): array
    {
        $map = $map ?? config('transliterate.map');
        $vendorMapsPath = __DIR__ . '/maps/';

        $customMaps = config('transliterate.maps');
        if ($customMaps !== null && array_key_exists($map, $customMaps)) {
            return require $customMaps[$map];
        }

        return require $vendorMapsPath . $map . '.php';
    }

    /**
     * Apply a series of transformations defined as closures in the configuration file.
     *
     * @param string $string
     * @return string
     */
    private static function applyTransformers(string $string): string
    {
        foreach (Transformer::getAll() as $transformer) {
            $string = $transformer($string);
        }

        return $string;
    }
}
