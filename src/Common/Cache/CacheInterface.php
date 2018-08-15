<?php

namespace Refactor\Common\Cache;

interface CacheInterface
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value);
}
