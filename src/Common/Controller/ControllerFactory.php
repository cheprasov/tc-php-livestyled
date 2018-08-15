<?php
namespace Refactor\Common\Controller;

use Refactor\Common\Exception\AppException;
use Refactor\Common\Request\Request;
use Refactor\Common\Route\RouteInterface;

class ControllerFactory
{
    /**
     * @param string $class
     * @param Request $Request
     * @param RouteInterface $Route
     * @return ControllerInterface
     * @throws AppException
     */
    public static function create($class, Request $Request, RouteInterface $Route)
    {
        if (!is_subclass_of($class, ControllerInterface::class)) {
            throw new AppException("Class {$class} should implement ControllerInterface");
        }
        return new $class($Request, $Route);
    }
}
