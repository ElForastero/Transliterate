<?php

declare(strict_types=1);

namespace ElForastero\Transliterate;

use Transliterator as IntlTransliterator;

/**
 * Feel free to change it.
 * Either by pull request or forking.
 *
 * Class Transliterator
 *
 * @author Eugene Dzhumak <elforastero@ya.ru>
 */
class Transliterator
{
    /**
     * @var string
     */
    private $lang;
    /**
     * @var
     */
    private $map;

    public function __construct(string $lang = null, string $map = null)
    {
        $this->lang = $lang;
        $this->map = $map;
    }

    /**
     * Change transliterating text language.
     *
     * @param string $lang one of the Map::LANG_* constants or custom language
     *
     * @return Transliterator
     */
    public function from(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Change transliteration map.
     *
     * @param string $map name of the transliteration map
     *
     * @return Transliterator
     */
    public function useMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Transliterate the given string.
     *
     * @param string $text
     *
     * @return string
     */
    public function make(string $text): string
    {
        $map = $this->getMap();
        $transliterated = str_replace(array_keys($map), array_values($map), $text);

        if (true === config('transliterate.remove_accents', false)) {
            $transliterator = IntlTransliterator::create('Any-Latin; Latin-ASCII');
            $transliterated = $transliterator->transliterate($transliterated);
        }

        return self::applyTransformers($transliterated);
    }

    /**
     * Create a slug by converting and removing all non-ascii characters.
     *
     * @param string $text
     *
     * @return string
     */
    public function slugify(string $text): string
    {
        $map = $this->getMap();
        $text = str_replace(array_keys($map), array_values($map), trim($text));

        $transliterator = IntlTransliterator::create('Any-Latin; Latin-ASCII; Lower()');

        $text = $transliterator->transliterate($text);
        $text = str_replace('&', 'and', $text);

        return preg_replace(
            ['/[^\w\s]/', '/\s+/'],
            ['', '-'],
            $text
        );
    }

    /**
     * Get map array according to config file.
     */
    private function getMap(): array
    {
        $map = $this->map ?? config('transliterate.default_map');
        $lang = $this->lang ?? config('transliterate.default_lang');
        $customMaps = config('transliterate.custom_maps');

        $vendorMapsPath = __DIR__.DIRECTORY_SEPARATOR.'maps'.DIRECTORY_SEPARATOR;
        $path = $customMaps[$lang][$map] ?? $vendorMapsPath.$lang.DIRECTORY_SEPARATOR.$map.'.php';

        if (!file_exists($path)) {
            throw new \InvalidArgumentException("The transliteration map '${path}' doesn't exist");
        }

        /* @noinspection PhpIncludeInspection */
        return require $path;
    }

    /**
     * Apply a series of transformations defined as closures in the configuration file.
     *
     * @param string $string
     *
     * @return string
     */
    private function applyTransformers(string $string): string
    {
        foreach (Transformer::getAll() as $transformer) {
            $string = $transformer($string);
        }

        return $string;
    }
}
