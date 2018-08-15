<?php

namespace Refactor\Application\Repository;

use Refactor\Common\Storage\CSVStorage;
use Refactor\Environment;

class RepositoryFactory
{
    /**
     * @return \Refactor\Common\Repository\RepositoryInterface
     */
    public static function createUserRepository()
    {
        $Storage = new CSVStorage(
            Environment::getDataDir() . 'users.csv',
            [
                0 => 'id',
                1 => 'first_name',
                2 => 'last_name',
            ]
        );

        $Cache = null; // todo: Add Cache

        return new UserRepository($Storage, $Cache);
    }
}
