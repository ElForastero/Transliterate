<?php

namespace ElForastero\Transliterate\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('transliterate.maps', [
            'test' => __DIR__ . '/fixtures/maps/test.php',
        ]);
    }
}