<?php

namespace Refactor\Common\Response;

interface ResponseInterface
{
    const CODE_OK = 200;
    const CODE_NO_CONTENT = 204;
    const CODE_BAD_REQUEST = 400;
    const CODE_NOT_FOUND = 404;

    const CONTENT_TYPE_HTML = 'text/html';
    const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @return int
     */
    public function getCode();

    /**
     * @param int $code
     */
    public function setCode($code);

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * @param string $key
     * @param string $value
     */
    public function setHeader($key, $value);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param mixed $body
     */
    public function setBody($body);
}
