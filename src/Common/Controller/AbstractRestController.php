<?php

namespace Refactor\Common\Controller;

use Refactor\Common\Exception\RestError;
use Refactor\Common\Response\ResponseFactory;

abstract class AbstractRestController extends AbstractController
{
    /**
     * @return \Refactor\Common\Response\ResponseInterface
     */
    protected function getResponse()
    {
        return $this->Response ?: $this->Response = ResponseFactory::createJsonResponse();
    }

    public function run()
    {
        try {
            return parent::run();
        } catch (RestError $Error) {
            $Response = $this->getResponse();
            $Response->setCode($Error->getCode());
            $Response->setBody(['error' => $Error->getMessage()]);
            return $Response;
        }
    }

}
