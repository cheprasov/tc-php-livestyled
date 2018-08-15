<?php

namespace Refactor\Common\Response;

class Response implements ResponseInterface
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $headers = [
        'Access-Control-Allow-Origin' => '*',
    ];

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @param $code
     */
    public function __construct($code)
    {
        $this->setCode($code);
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function setCode($code)
    {
        $this->code = (int)$code;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @inheritdoc
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritdoc
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}
