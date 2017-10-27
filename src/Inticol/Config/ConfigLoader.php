<?php

namespace Inticol\Config;

class ConfigLoader
{
    protected $config = [];

    public function __construct($configDir, $environment)
    {
        $this->config = $this->loadFile($configDir . '/default.php');
        if (!empty($environment)) {
            $this->mergeFile($configDir . '/' . $environment . '.php');
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function mergeFile($filename)
    {
        $custom = $this->loadFile($filename);
        $this->config = array_replace_recursive($this->config, $custom);
        return $this->config;
    }

    protected function loadFile($filename)
    {
        if (!file_exists($filename)) {
            return [];
        }
        $config = require_once($filename);
        array_walk_recursive($config, function (&$value) {
            $testStr = '__';
            if ((strpos($value, $testStr) === 0) &&
                (substr_compare($value, $testStr, strlen($value)-strlen($testStr), strlen($testStr)) === 0)
            ) {
                $envName = substr($value, 2, strlen($value) - 4);
                $value = !empty(getenv($envName)) ? trim(getenv($envName), '"') : '';
            }
        });
        return $config;
    }
}
