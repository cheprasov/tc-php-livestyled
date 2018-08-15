<?php

namespace Refactor\Common\Response;

use Refactor\Common\Exception\AppException;

class JsonResponse extends Response
{
    /**
     * @var array
     */
    protected $headers = [
        'Content-Type' => ResponseInterface::CONTENT_TYPE_JSON,
        'Access-Control-Allow-Origin' => '*',
    ];

    /**
     * @param mixed $body
     * @throws AppException
     */
    public function setBody($body)
    {
        $json = json_encode($body, JSON_UNESCAPED_UNICODE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AppException(json_last_error());
        }
        $this->body = $json;
    }
}
