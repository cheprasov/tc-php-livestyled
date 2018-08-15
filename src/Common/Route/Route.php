<?php

namespace Refactor\Common\Route;

class Route implements RouteInterface
{
    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array|null
     */
    protected $params;

    /**
     * Route constructor.
     * @param string $controller
     * @param string $action
     * @param null|array $params
     */
    public function __construct($controller, $action, array $params = null)
    {
        $this->controller = (string)$controller;
        $this->action = (string)$action;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $key
     * @return array|null
     */
    public function getParam($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }
}
