<?php

namespace Refactor\Common\Controller;

use Refactor\Common\Exception\AppException;
use Refactor\Common\Request\Request;
use Refactor\Common\Response\ResponseFactory;
use Refactor\Common\Response\ResponseInterface;
use Refactor\Common\Route\RouteInterface;

abstract class AbstractController implements ControllerInterface
{
    /**
     * @var \Refactor\Common\Request\Request
     */
    protected $Request;

    /**
     * @var \Refactor\Common\Response\ResponseInterface
     */
    protected $Route;

    /**
     * @var \Refactor\Common\Response\ResponseInterface
     */
    protected $Response;

    /**
     * @param \Refactor\Common\Request\Request $Request
     * @param \Refactor\Common\Response\ResponseInterface $Route
     */
    public function __construct(Request $Request, RouteInterface $Route)
    {
        $this->Request = $Request;
        $this->Route = $Route;
    }

    /**
     * @return \Refactor\Common\Response\ResponseInterface
     */
    protected function getResponse()
    {
        return $this->Response ?: $this->Response = ResponseFactory::createResponse();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $action = $this->Route->getAction();
        if (!method_exists($this, $action)) {
            throw new AppException("Route action '{$action}' is not found");
        }
        $result = $this->$action();
        if ($result instanceof ResponseInterface) {
            return $result;
        }
        $Response = $this->getResponse();
        if (isset($result)) {
            $Response->setBody($result);
        }
        return $Response;
    }
}
