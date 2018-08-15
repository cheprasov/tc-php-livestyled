<?php

namespace Refactor\Common\Repository;

interface RepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getOne($id);

    /**
     * @return array
     */
    public function getList();
}
