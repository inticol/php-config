<?php
namespace Inticol\Config\UnitTest;

use PHPUnit\Framework\TestCase;
use Inticol\Config\ConfigLoader;

final class ConfigLoaderTest extends TestCase
{
    public function testConfigLoader()
    {
        putenv('TEST_PATHS_BASE=/opt');
        $configLoader = new ConfigLoader(__DIR__ . '/config');
        $config = $configLoader->getConfig();
        $this->assertTrue(is_array($config));
        $this->assertEquals($config['paths']['tmp'], '/tmp');
        $this->assertEquals($config['paths']['base'], '/opt');
    }
}
