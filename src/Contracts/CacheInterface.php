<?php

namespace Juhara\ZzzCache\Contracts;

/**
 * interface for cache manager
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface CacheInterface
{
    /**
     * retrieve cached item by name
     * @param  string $cacheId cached item identifier
     * @return mixed cached item
     */
    public function get($cacheId);


    /**
     * add cacheable item and associate it with cacheName
     * @param string    $cacheId  cached item identifier
     * @param Cacheable $cacheable item to cached
     */
    public function add($cacheId, Cacheable $cacheable);

    /**
    * test availability of cached item previously added by add()
    * @param  string $cacheId cached item identifier
    * @return boolean
    */
    public function has($cacheId);

    /**
     * remove cached item by name
     * @param  string $cacheId cached item identifier
     * @return void
     */
    public function remove($cacheId);

    /**
     * clear all cached items
     * @return void
     */
    public function clear();
}
