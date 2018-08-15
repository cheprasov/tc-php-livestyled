<?php
namespace Refactor\Application\Controller;

use Refactor\Application\Repository\RepositoryFactory;
use Refactor\Common\Controller\AbstractRestController;
use Refactor\Common\Exception\RestError;
use Refactor\Common\Response\ResponseInterface;

class UsersController extends AbstractRestController
{
    /**
     * @var \Refactor\Common\Repository\RepositoryInterface
     */
    protected $Repository;

    protected function getRepository()
    {
        return $this->Repository ?: $this->Repository = RepositoryFactory::createUserRepository();
    }

    /**
     * @return array|null
     */
    public function getOne()
    {
        if (!$userId = (int)$this->Route->getParam('id')) {
            throw new RestError('Wrong user id', ResponseInterface::CODE_BAD_REQUEST);
        }

        if (!$data = $this->getRepository()->getOne($userId)) {
            throw new RestError('Unable to find user', ResponseInterface::CODE_NOT_FOUND);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->getRepository()->getList();
    }
}
