<?php

namespace ElForastero\Transliterate\Tests;

use ElForastero\Transliterate\Transliteration;

class TransliterationTest extends TestCase
{
    private $initialString = 'Если б мишки были пчёлами, то они бы нипочем, никогда и не подумали так высо́ко строить дом.';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('transliterate.maps', [
            'test' => __DIR__ . '/fixtures/maps/test.php',
        ]);
    }

    public function testMake()
    {
        $commonResult = 'Esli b mishki bili pchyolami, to oni bi nipochem, nikogda i ne podumali tak visoko stroit dom.';
        $gost2000Result = 'Esli b mishki by\'li pchyolami, to oni by\' nipochem, nikogda i ne podumali tak vy\'soko stroit` dom.';

        $this->assertEquals($commonResult, Transliteration::make($this->initialString, 'common'));
        $this->assertEquals($gost2000Result, Transliteration::make($this->initialString, 'gost2000'));
    }

    public function testCustomMap()
    {
        $testResult = 'Если d мишки dыли пчёлbми, то они dы нипочем, никогдb и не подумbли тbк fысоко строить дом.';

        $this->assertEquals($testResult, Transliteration::make($this->initialString, 'test'));
    }
}
