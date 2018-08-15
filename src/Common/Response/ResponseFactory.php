<?php

namespace Refactor\Common\Response;

class ResponseFactory
{
    /**
     * @return ResponseInterface
     */
    protected static function create($class, $code, $body)
    {
        /** @var ResponseInterface $Response */
        $Response = new $class($code);
        if ($body) {
            $Response->setBody($body);
        }
        return $Response;
    }

    /**
     * @return ResponseInterface
     */
    public static function createResponse($code = ResponseInterface::CODE_OK, $body = null)
    {
        return static::create(Response::class, $code, $body);
    }

    /**
     * @return ResponseInterface
     */
    public static function createJsonResponse($code = ResponseInterface::CODE_OK, $body = null)
    {
        return static::create(JsonResponse::class, $code, $body);
    }
}
