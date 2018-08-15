<?php
namespace Refactor\Common\Controller;

interface ControllerInterface
{
    /**
     * @param $action
     * @return \Refactor\Common\Response\ResponseInterface
     */
    public function run();
}
