<?php

namespace Refactor\Common\Route;

use Refactor\Application\Controller\MiscController;

class RouteFactory
{
    /**
     * @param $config
     * @param $params
     * @return RouteInterface
     */
    public static function create($config, $params = null)
    {
        return new Route(
            isset($config['controller']) ? $config['controller'] : '',
            isset($config['action']) ? $config['action'] : null,
            $params
        );
    }

    /**
     * @return RouteInterface
     */
    public static function createNotFound()
    {
        return new Route(MiscController::class, 'pageNotFound');
    }
}
