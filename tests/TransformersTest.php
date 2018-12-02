<?php

namespace ElForastero\Transliterate\Tests;

use ElForastero\Transliterate\Transformer;
use ElForastero\Transliterate\Transliteration;

class TransformersTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        Transformer::override([
            \Closure::fromCallable('trim'),
            \Closure::fromCallable('strtoupper'),
        ]);
    }

    public function testTransformers()
    {
        $initialString = '  Строка с пробелами  ';

        $this->assertEquals(
            strtoupper(trim('  Stroka s probelami  ')),
            Transliteration::make($initialString)
        );
    }
}