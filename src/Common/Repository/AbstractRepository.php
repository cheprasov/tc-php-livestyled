<?php

namespace Refactor\Common\Repository;

use Refactor\Common\Cache\CacheInterface;
use Refactor\Common\Storage\StorageInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var \Refactor\Common\Storage\StorageInterface
     */
    protected $Storage;

    /**
     * @var \Refactor\Common\Cache\CacheInterface
     */
    protected $Cache;

    /**
     * @var string
     */
    protected $cachePrefix = '';

    /**
     * @param StorageInterface $Storage
     * @param CacheInterface $Cache
     */
    public function __construct(StorageInterface $Storage, CacheInterface $Cache = null)
    {
        $this->Storage = $Storage;
        $this->Cache = $Cache;
    }

    /**
     * @return string
     */
    public function getCacheKey(/* param1, param2, ... */)
    {
        return $this->cachePrefix . ':' . implode('_', func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function getOne($id)
    {
        $cacheKey = $this->getCacheKey('id', $id);

        if ($this->Cache) {
            if ($data = $this->Cache->get($cacheKey)) {
                return $data;
            }
        }

        if ($data = $this->Storage->getOne($id)) {
            if ($this->Cache) {
                $this->Cache->set($cacheKey, $data);
            }
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getList()
    {
        $cacheKey = $this->getCacheKey('list');

        if ($this->Cache) {
            if ($data = $this->Cache->get($cacheKey)) {
                return $data;
            }
        }

        if ($data = $this->Storage->getList()) {
            if ($this->Cache) {
                $this->Cache->set($cacheKey, $data);
            }
        }

        return $data;
    }
}
