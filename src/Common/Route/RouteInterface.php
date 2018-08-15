<?php

namespace Refactor\Common\Route;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getController();

    /**
     * @return string
     */
    public function getAction();

    /**
     * @param string $key
     * @return array|null
     */
    public function getParam($key);
}
