<?php

namespace Refactor\Application;

use Refactor\Common\Controller\ControllerFactory;
use Refactor\Common\Request\Request;
use Refactor\Common\Response\ResponseFactory;
use Refactor\Common\Response\ResponseInterface;
use Refactor\Common\Route\RouteFactory;

class Application
{
    /**
     * @var  \Refactor\Common\Request\Request
     */
    protected $Request;

    /**
     * @var array|null
     */
    protected $routes;

    /**
     * @return \Refactor\Common\Request\Request
     */
    protected function getRequest()
    {
        return $this->Request ?: $this->Request = new Request();
    }

    public function run()
    {
        try {
            $Controller = $this->getController();
            $this->echoResponse($Controller->run());
        } catch (\Exception $Exception) {
            // todo: do not show internal errors to client.
            $Response = ResponseFactory::createResponse(500, "Internal Error: {$Exception->getMessage()}");
            $this->echoResponse($Response);
        }
    }

    /**
     * @param \Refactor\Common\Response\ResponseInterface $Response
     */
    protected function echoResponse(ResponseInterface $Response)
    {
        http_response_code($Response->getCode());
        foreach ($Response->getHeaders() as $key => $value) {
            header("{$key}:{$value}", true);
        }
        echo $Response->getBody();
    }

    /**
     * @return \Refactor\Common\Controller\ControllerInterface
     */
    protected function getController()
    {
        if (!$Route = $this->getRoute()) {
            $Route = RouteFactory::createNotFound();
        }
        return ControllerFactory::create($Route->getController(), $this->getRequest(), $Route);
    }

    /**
     * @return \Refactor\Common\Route\RouteInterface
     */
    protected function getRoute()
    {
        if (!$this->routes) {
            $this->routes = include(__DIR__ . '/routes.php');
        }

        $Request = $this->getRequest();
        $method = $Request->getMethod();
        $uri = $Request->getUri();

        foreach ($this->routes as $name => $config) {
            if (empty($config['method'])) {
                continue;
            }
            if (is_array($config['method'])) {
                if (!in_array($method, $config['method'])) {
                    continue;
                }
            } elseif ($config['method'] !== $method) {
                continue;
            }
            if (!preg_match($config['regexp'], $uri, $matches)) {
                continue;
            }
            return RouteFactory::create($config, $matches);
        }
        return null;
    }

}
