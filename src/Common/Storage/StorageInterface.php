<?php

namespace Refactor\Common\Storage;

interface StorageInterface
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
