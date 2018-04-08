<?php

namespace Juhara\SlimCache;

use Juhara\SlimCache\Contracts\CacheInterface;
use Juhara\SlimCache\Contracts\Cacheable;
use Juhara\SlimCache\Contracts\CacheStorageInterface;
use Juhara\SlimCache\Exceptions\CacheNameNotFound;

/**
 * [SimpleCache description]
 */
class Cache implements CacheInterface
{
    /**
     * time utility class
     * @var TimeUtility
     */
    private $timeUtil;

    /**
     * cache storage interface
     * @var CacheStorageInterface
     */
    private $storage;

    /**
     * cached items
     * @var array
     */
    protected $cachedItems = [];

    /**
     * constructor
     * @param TimeUtility $timeUtil time helper class
     */
    public function __construct(CacheStorageInterface $storage, TimeUtility $timeUtil)
    {
        $this->storage = $storage;
        $this->timeUtil = $timeUtil;
    }

    protected function expired($cacheName)
    {
        $item = $this->cachedItems[$cacheName];
        return $this->storage->exists($cacheName) ||
               $this->timeUtil->expired($item->expiry);
    }

    protected function getCachedItem($cacheName)
    {
        return $this->storage->read($cacheName);
    }

    protected function getFromCacheable($cacheName)
    {
        $data = $this->cachedItems[$cacheName]->cacheable->data();
        $this->storage->write($cacheName, $data);
        return $data;
    }

    /**
     * test availability of cache name and throw exception if not exist
     * @param  string $cacheName cache identifier
     * @return void
     * @throws CacheNameNotFound
     */
    private function throwExceptionIfNotExists($cacheName)
    {
        if (! $this->has($cacheName)) {
            throw new CacheNameNotFound("Cache {$cacheName} not found.");
        }
    }

    /**
     * retrieve cached item by name
     * @param  string $cacheName cached item identifier
     * @return mixed cached item
     * @throws CacheNameNotFound
     */
    public function get($cacheName)
    {
        $this->throwExceptionIfNotExists($cacheName);

        if (! $this->expired($acacheName)) {
            return $this->getCachedItem($cacheName);
        }

        return $this->getFromCacheable($cacheName);
    }

    /**
     * add cacheable item and associate it with cacheName
     * @param string    $cacheName  cached item identifier
     * @param Cacheable $cacheable item to cached
     */
    public function add($cacheName, Cacheable $cacheable)
    {
        $this->cachedItems[$cacheName] = (object) [
            'cacheable' => $cacheable,
            'expiry' => $this->timeUtil->expiry($cacheable->ttl());
        ];
        return $this;
    }

    /**
    * test availability of cached item previously added by add()
    * @param  string $cacheName cached item identifier
    * @return boolean
    */
    public function has($cacheName)
    {
        return isset($this->cachedItems[$cacheName]);
    }

    /**
     * remove cached item by name
     * @param  string $cacheName cached item identifier
     * @return void
     * @throws CacheNameNotFound
     */
    public function remove($cacheName)
    {
        $this->throwExceptionIfNotExists($cacheName);
        unset($this->cachedItems[$cacheName]);
        return $this;
    }

    /**
     * clear all cached items
     * @return void
     */
    public function clear()
    {
        $this->cachedItems = [];
    }

}
