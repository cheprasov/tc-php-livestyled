<?php

namespace Refactor\Application\Repository;

use Refactor\Common\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $cachePrefix = 'users';
}
