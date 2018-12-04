<?php

namespace ElForastero\Transliterate\Tests;

use ElForastero\Transliterate\Transliterator;

class TransliterationTest extends TestCase
{
    private $initialString = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('transliterate.custom_maps', [
            'ru' => [
                'test' => __DIR__ . '/fixtures/maps/test.php',
            ],
        ]);
    }

    public function testMake()
    {
        $commonResult = 'abvgdeyozhziyklmnoprstufhcchshshhieyuyaABVGDEYoZhZIYKLMNOPRSTUFHCChShShhIEYuYa';
        $gost2000Result = 'abvgdeyozhzijklmnoprstufxcchshshh``y\'`e`yuyaABVGDEYoZhZIJKLMNOPRSTUFXCChShShh``Y\'`E`YuYa';

        $transliterator = (new Transliterator)->from('ru')->useMap('common');

        $this->assertEquals($commonResult, $transliterator->make($this->initialString));
        $this->assertEquals($gost2000Result, $transliterator->useMap('GOST_7.79.2000')->make($this->initialString));
    }

    public function testCustomMap()
    {
        $transliterator = (new Transliterator)->from('ru')->useMap('test');
        $this->assertEquals(str_repeat('a', 66), $transliterator->make($this->initialString));
    }

    public function testMakeWithInvalidMapName()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Transliterator)->useMap('non-existent')->make('Test');
    }
}
