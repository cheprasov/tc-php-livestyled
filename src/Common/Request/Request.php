<?php

namespace Refactor\Common\Request;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @return string
     */
    public function getUri()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    }

    /**
     * @param string $param
     * @return string|null
     */
    public function getQueryParam($param)
    {
        return isset($_GET[$param]) ? $_GET[$param] : null;
    }

}
