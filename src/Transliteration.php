<?php

namespace ElForastero\Transliterate;

/**
 * Feel free to change it.
 * Either by pull request or forking.
 *
 * Class Transliteration
 * @package ElForastero\Transliterate
 */
class Transliteration
{
    /**
     * Default transliteration map
     * @var string common|gost2000
     */
    private static $map = 'common';

    /**
     * Default transliteration method
     * @var string text|filename|url
     */
    private static $type = 'text';

    /**
     * Lowercase string or not
     * @var bool
     */
    private static $lowercase = false;


    /**
     * @param       $string
     * @param array $params Массив с параметрами.
     *                      lowercase => true
     *                      type => url | filename Подчеркивания или дефисы
     *                      map => gost2000 Таблица транслитерации ГОСТ 2000. По умолчанию используется общепринятая.
     * @return mixed|string
     */
    public static function make($string, array $params = [])
    {
        self::parseParameters($params);

        $map = self::getTransliterationMap();
        $chars = implode('', array_keys($map));
        $clearedString = preg_replace("/[^\\s\\w${chars}]/iu", '', $string);
        $transliterated = str_replace(array_keys($map), array_values($map), $clearedString);
        return self::applyTransformer($transliterated);
    }

    /**
     * Транслитерация общепринятым способом
     * @return array
     */
    public static function getCommonMap()
    {
        return [
            'ж' => 'zh', 'ч' => 'ch', 'щ' => 'shh', 'ш' => 'sh',
            'ю' => 'yu', 'ё' => 'yo', 'я' => 'ya', 'э' => 'e',
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p',
            'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ъ' => '',
            'ь' => '', 'ы' => 'i',

            'Ж' => 'Zh', 'Ч' => 'Ch', 'Щ' => 'Shh', 'Ш' => 'Sh',
            'Ю' => 'Yu', 'Ё' => 'Yo', 'Я' => 'Ya', 'Э' => 'E',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L',
            'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P',
            'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ъ' => '',
            'Ь' => '', 'Ы' => 'I',
        ];
    }

    /**
     * Транслитерация по ГОСТ 7.79-2000
     * @return array
     */
    public static function getGost2000Map()
    {
        return [
            'ж' => 'zh', 'ч' => 'ch', 'щ' => 'shh', 'ш' => 'sh',
            'ю' => 'yu', 'ё' => 'yo', 'я' => 'ya', 'э' => 'e`',
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e', 'з' => 'z',
            'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p',
            'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'x', 'ц' => 'c', 'ъ' => '``',
            'ь' => '`', 'ы' => 'y\'',

            'Ж' => 'Zh', 'Ч' => 'Ch', 'Щ' => 'Shh', 'Ш' => 'Sh',
            'Ю' => 'Yu', 'Ё' => 'Yo', 'Я' => 'Ya', 'Э' => 'E`',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'З' => 'Z',
            'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L',
            'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P',
            'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'X', 'Ц' => 'C', 'Ъ' => '``',
            'Ь' => '`', 'Ы' => 'Y\'',
        ];
    }

    /**
     * Pareses parameters array. Just for clearance.
     * @param array $parameters
     */
    private static function parseParameters(array $parameters)
    {
        if (isset($parameters['map'])) {
            if (!in_array($parameters['map'], ['common', 'gost2000'])) {
                throw new \InvalidArgumentException("The 'map' parameter must be either 'common' or 'gost2000'");
            }

            self::$map = $parameters['map'];
        }

        if (isset($parameters['type'])) {
            if (!in_array($parameters['type'], ['filename', 'url', 'text'])) {
                throw new \InvalidArgumentException("The 'type' parameter must be one of 'filename', 'url' or 'text'");
            }

            self::$type = $parameters['type'];
        }

        if (isset($parameters['lowercase'])) {
            if (!is_bool($parameters['lowercase'])) {
                throw new \InvalidArgumentException("The 'lowercase' parameter must be boolean");
            }

            self::$lowercase = $parameters['lowercase'];
        }
    }

    /**
     * Get transliteration map
     * @return array
     */
    private static function getTransliterationMap()
    {
        if ('gost2000' === self::$map) {
            return self::getGost2000Map();
        }

        return self::getCommonMap();
    }

    /**
     * Applies various transformations to the string
     * @param $string
     * @return mixed|string
     */
    private static function applyTransformer($string)
    {
        if ('filename' === self::$type) {
            $string = preg_replace('/\s+/', '_', $string);
        } else if ('url' === self::$type) {
            $string = preg_replace('/\s+/', '-', $string);
        }

        if (true === self::$lowercase) {
            $string = strtolower($string);
        }

        return $string;
    }
}
