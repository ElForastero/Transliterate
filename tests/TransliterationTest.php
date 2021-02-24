<?php

namespace ElForastero\Transliterate\Tests;

use ElForastero\Transliterate\Transliterator;
use ElForastero\Transliterate\Map;

/**
 * @covers \ElForastero\Transliterate\Transliterator
 */
class TransliterationTest extends TestCase
{
    private $initialString = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('transliterate.custom_maps', [
            'ru' => [
                'test' => __DIR__.'/fixtures/maps/test.php',
            ],
        ]);
    }

    public function testMake()
    {
        $commonResult = 'abvgdeyozhziyklmnoprstufhcchshshhieyuyaABVGDEYoZhZIYKLMNOPRSTUFHCChShShhIEYuYa';
        $gost2000Result = 'abvgdeyozhzijklmnoprstufxcchshshh``y\'`e`yuyaABVGDEYoZhZIJKLMNOPRSTUFXCChShShh``Y\'`E`YuYa';

        $transliterator = new Transliterator(Map::LANG_RU, Map::DEFAULT);

        $this->assertEquals($commonResult, $transliterator->make($this->initialString));
        $this->assertEquals($gost2000Result, $transliterator->useMap('GOST_7.79.2000')->make($this->initialString));
    }

    public function testSlugify()
    {
        $initialString = ' Съешь еще этих мягких французских булок, да выпей чаю! & 123';
        $expectedString = 'sesh-eshhe-etih-myagkih-francuzskih-bulok-da-vipey-chayu-and-123';

        $this->assertEquals($expectedString, (new Transliterator())->slugify($initialString));
    }

    public function testCustomMap()
    {
        $transliterator = (new Transliterator(Map::LANG_RU, 'test'));
        $this->assertEquals(str_repeat('a', 66), $transliterator->make($this->initialString));
    }

    public function testMakeWithInvalidMapName()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Transliterator(Map::LANG_RU, 'non-existent'))->make('Test');
    }
}
