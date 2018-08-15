<?php

namespace Refactor;

class Environment
{
    /**
     * @var string
     */
    protected static $dataDir;

    /**
     * @return string
     */
    public static function getDataDir()
    {
        if (!isset(static::$dataDir)) {
            static::$dataDir = realpath(__DIR__ . '/../data/') . '/';
        }
        return static::$dataDir;
    }
}
