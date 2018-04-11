<?php

namespace Juhara\ZzzCache;

use Juhara\ZzzCache\Contracts\CacheInterface;
use Juhara\ZzzCache\Contracts\Cacheable;
use Juhara\ZzzCache\Contracts\CacheStorageInterface;
use Juhara\ZzzCache\Contracts\ExpiryCalculatorInterface;
use Juhara\ZzzCache\Exceptions\CacheNameNotFound;

/**
 * Cache implementation
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class Cache implements CacheInterface
{
    /**
     * time utility class
     * @var ExpiryCalculatorInterface
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
     * @param CacheStorageInterface $storage cache storage implementation
     * @param ExpiryCalculatorInterface $timeUtil time helper class
     */
    public function __construct(
        CacheStorageInterface $storage,
        ExpiryCalculatorInterface $timeUtil
    ) {
        $this->storage = $storage;
        $this->timeUtil = $timeUtil;
    }

    /**
     * test if cache is expired
     * @param  string $cacheId cache identifier
     * @return boolean true if expired or false otherwise
     */
    private function expired($cacheId)
    {
        $item = $this->cachedItems[$cacheId];
        return (! $this->storage->exists($cacheId)) ||
               $this->timeUtil->expired($item->expiry);
    }

    /**
     * read cached content by id from cache storage
     *
     * @param  string $cacheId cache identifier
     * @return string  cached content
     */
    private function getCachedItem($cacheId)
    {
        return $this->storage->read($cacheId);
    }

    /**
     * read content from Cacheable instance and write it to cache
     * storage when cache is missed
     *
     * @param  string $cacheId cache identifier
     * @return string content
     */
    private function getFromCacheable($cacheId)
    {
        $data = $this->cachedItems[$cacheId]->cacheable->data();
        $this->storage->write($cacheId, $data);
        return $data;
    }

    /**
     * test availability of cache name and throw exception if not exist
     * @param  string $cacheId cache identifier
     * @return void
     * @throws CacheNameNotFound
     */
    private function throwExceptionIfNotExists($cacheId)
    {
        if (! $this->has($cacheId)) {
            throw new CacheNameNotFound("Cache {$cacheId} not found.");
        }
    }

    /**
     * retrieve cached item by id
     * @param  string $cacheId cached item identifier
     * @return string cached item
     * @throws CacheNameNotFound
     */
    public function get($cacheId)
    {
        $this->throwExceptionIfNotExists($cacheId);

        if ($this->expired($cacheId)) {
            return $this->getFromCacheable($cacheId);
        }

        return $this->getCachedItem($cacheId);
    }

    /**
     * add cacheable item and associate it with cache identifier
     *
     * @param string    $cacheId  cached item identifier
     * @param Cacheable $cacheable item to cached
     */
    public function add($cacheId, Cacheable $cacheable)
    {
        $this->cachedItems[$cacheId] = (object) [
            'cacheable' => $cacheable,
            'expiry' => $this->timeUtil->expiry($cacheable->ttl())
        ];
        return $this;
    }

    /**
    * test availability of cached item previously added by add()
    * @param  string $cacheId cached item identifier
    * @return boolean
    */
    public function has($cacheId)
    {
        return isset($this->cachedItems[$cacheId]);
    }

    /**
     * remove cached item by id
     * @param  string $cacheId cached item identifier
     * @return void
     * @throws CacheNameNotFound
     */
    public function remove($cacheId)
    {
        $this->throwExceptionIfNotExists($cacheId);
        unset($this->cachedItems[$cacheId]);
        $this->storage->remove($cacheId);
        return $this;
    }

    /**
     * clear all cached items
     * @return void
     */
    public function clear()
    {
        $this->cachedItems = [];
        $this->storage->clear();
    }

}
