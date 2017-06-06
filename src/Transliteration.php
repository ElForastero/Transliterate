<?php
namespace ElForastero\Transliterate;

class Transliteration
{
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
        if(!isset($params['map'])) {
            $map = self::getDefaultMap();
        } else {
            switch($params['map']) {
                case 'gost2000':
                    $map = self::getGost2000Map();
                    break;
                default:
                    $map = self::getDefaultMap();
                    break;
            }
        }

        $chars = implode('', array_keys($map));
        $clearedString = preg_replace("/[^\\s\\w$chars]/iu", '', $string);
        $transliterated = str_replace(array_keys($map), array_values($map), $clearedString);

        if(isset($params['type'])) {
            switch($params['type']) {
                case 'url':
                    $transliterated = preg_replace('/\s+/', '-', $transliterated);
                    break;
                case 'filename':
                    $transliterated = preg_replace('/\s+/', '_', $transliterated);
                    break;
                case 'text':
                    $transliterated = preg_replace('/\s+/', ' ', $transliterated);
                    break;
            }
        } else {
            $transliterated = preg_replace('/\s+/', '-', $transliterated);
        }

        if(isset($params['lowercase']) && $params['lowercase']) {
            $transliterated = strtolower($transliterated);
        }

        return trim($transliterated, '_-');
    }

    /**
     * Транслитерация общепринятым способом
     * @return array
     */
    public static function getDefaultMap()
    {
        return [
            'ж' => 'zh', 'ч' => 'ch', 'щ' => 'shh', 'ш' => 'sh',
            'ю' => 'yu', 'ё' => 'yo', 'я' => 'ya',  'э' => 'e',
            'а' => 'a',  'б' => 'b',  'в' => 'v',
            'г' => 'g',  'д' => 'd',  'е' => 'e',   'з' => 'z',
            'и' => 'i',  'й' => 'y',  'к' => 'k',   'л' => 'l',
            'м' => 'm',  'н' => 'n',  'о' => 'o',   'п' => 'p',
            'р' => 'r',  'с' => 's',  'т' => 't',   'у' => 'u',
            'ф' => 'f',  'х' => 'h',  'ц' => 'c',   'ъ' => '',
            'ь' => '',   'ы' => 'i',

            'Ж' => 'Zh', 'Ч' => 'Ch', 'Щ' => 'Shh', 'Ш' => 'Sh',
            'Ю' => 'Yu', 'Ё' => 'Yo', 'Я' => 'Ya',  'Э' => 'E',
            'А' => 'A',  'Б' => 'B',  'В' => 'V',
            'Г' => 'G',  'Д' => 'D',  'Е' => 'E',   'З' => 'Z',
            'И' => 'I',  'Й' => 'Y',  'К' => 'K',   'Л' => 'L',
            'М' => 'M',  'Н' => 'N',  'О' => 'O',   'П' => 'P',
            'Р' => 'R',  'С' => 'S',  'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',  'Х' => 'H',  'Ц' => 'C',   'Ъ' => '',
            'Ь' => '',   'Ы' => 'I',
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
            'ю' => 'yu', 'ё' => 'yo', 'я' => 'ya',  'э' => 'e`',
            'а' => 'a',  'б' => 'b',  'в' => 'v',
            'г' => 'g',  'д' => 'd',  'е' => 'e',   'з' => 'z',
            'и' => 'i',  'й' => 'j',  'к' => 'k',   'л' => 'l',
            'м' => 'm',  'н' => 'n',  'о' => 'o',   'п' => 'p',
            'р' => 'r',  'с' => 's',  'т' => 't',   'у' => 'u',
            'ф' => 'f',  'х' => 'x',  'ц' => 'c',   'ъ' => '``',
            'ь' => '`',  'ы' => 'y\'',

            'Ж' => 'Zh', 'Ч' => 'Ch', 'Щ' => 'Shh', 'Ш' => 'Sh',
            'Ю' => 'Yu', 'Ё' => 'Yo', 'Я' => 'Ya',  'Э' => 'E`',
            'А' => 'A',  'Б' => 'B',  'В' => 'V',
            'Г' => 'G',  'Д' => 'D',  'Е' => 'E',   'З' => 'Z',
            'И' => 'I',  'Й' => 'J',  'К' => 'K',   'Л' => 'L',
            'М' => 'M',  'Н' => 'N',  'О' => 'O',   'П' => 'P',
            'Р' => 'R',  'С' => 'S',  'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',  'Х' => 'X',  'Ц' => 'C',   'Ъ' => '``',
            'Ь' => '`',  'Ы' => 'Y\'',
        ];
    }
}
