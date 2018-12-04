<?php

declare(strict_types=1);

namespace ElForastero\Transliterate;

/**
 * Feel free to change it.
 * Either by pull request or forking.
 *
 * Class Transliteration
 *
 * @author Eugene Dzhumak <elforastero@ya.ru>
 *
 * @version 2.0.0
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

    /**
     * @param string $lang
     * @return Transliterator
     */
    public function from(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @param string $map
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

        if (config('transliterate.remove_accents', false) === true) {
            $transliterated = iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $transliterated);
        }

        return self::applyTransformers($transliterated);
    }

    /**
     * Get map array according to config file.
     *
     * @return array
     */
    private function getMap(): array
    {
        $map = $this->map ?? config('transliterate.default_map');
        $lang = $this->lang ?? config('transliterate.default_lang');
        $customMaps = config('transliterate.custom_maps');

        $vendorMapsPath = __DIR__ . DIRECTORY_SEPARATOR . 'maps' . DIRECTORY_SEPARATOR;
        $path = $customMaps[$lang][$map] ?? $vendorMapsPath . $lang . DIRECTORY_SEPARATOR . $map . '.php';

        if (!file_exists($path)) {
            throw new \InvalidArgumentException("The transliteration map '${path}' doesn't exist");
        }

        /** @noinspection PhpIncludeInspection */
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
