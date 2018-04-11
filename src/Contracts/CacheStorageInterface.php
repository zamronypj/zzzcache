<?php

namespace Juhara\ZzzCache\Contracts;

/**
 * interface for storage capable of storing cached data
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface CacheStorageInterface
{
    /**
     * test availability of cache
     * @param  string $cacheId cache identifier
     * @return boolean true if available or false otherwise
     */
    public function exists($cacheId);

    /**
     * read data from storage by cache id
     * @param  string $cacheId cache identifier
     * @return string data from storage in serialized format
     */
    public function read($cacheId);

    /**
     * write data to storage by cache id
     * @param  string $cacheId cache identifier
     * @param  string $data item to cache in serialized format
     * @return int number of bytes written
     */
    public function write($cacheId, $data);

    /**
     * remove data from storage by cache id
     * @param  string $cacheId cache identifier
     * @return boolean true if cache is successfully removed
     */
    public function remove($cacheId);

    /**
     * remove all data from storage
     */
    public function clear();
}
