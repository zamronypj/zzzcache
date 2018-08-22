<?php

namespace Juhara\ZzzCache\Psr;

use Psr\SimpleCache\CacheInterface as PsrCacheInterface;
use Juhara\ZzzCache\Contracts\CacheInterface;
use Juhara\ZzzCache\Contracts\CacheableFactoryInterface;

/**
 * Adapter implementation to support PSR-16 CacheInterface
 *
 * @link https://www.php-fig.org/psr/psr-16/
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class AdapterCache extends BaseAdapter implements PsrCacheInterface
{
    /**
     * zzzcache instance
     * @var Juhara\ZzzCache\Contracts\CacheInterface
     */
    private $zzzCache;

    /**
     * cacheble factory instance
     * @var Juhara\ZzzCache\Contracts\CacheableFactoryInterface
     */
    private $cacheableFactory;

    /**
     * default time to live in seconds
     * @var int
     */
    private $defaultTtl;

    /**
     * constructor
     * @param CacheInterface            $zzzCache         cache instance
     * @param CacheableFactoryInterface $cacheableFactory factory instance
     * @param int                       $defaultTtl       default time to live
     */
    public function __construct(
        CacheInterface $zzzCache,
        CacheableFactoryInterface $cacheableFactory,
        $defaultTtl
    ) {
        $this->zzzCache = $zzzCache;
        $this->cacheableFactory = $cacheableFactory;
        $this->defaultTtl = $defaultTtl;
    }

    /**
     * Fetches a value from the cache.
     *
     * @param string $key     The unique key of this item in the cache.
     * @param mixed  $default Default value to return if the key does not exist.
     *
     * @return mixed The value of the item from the cache, or $default in case of cache miss.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function get($key, $default = null)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        return $this->zzzCache->get($key);
    }

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string                 $key   The key of the item to store.
     * @param mixed                  $value The value of the item to store, must be serializable.
     * @param null|int|\DateInterval $ttl   Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function set($key, $value, $ttl = null)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        $timeToLive = is_null($ttl) ? $this->defaultTtl : $ttl;
        $cacheable = $this->cacheableFactory->build($value, $timeToLive);
        $this->zzzCache->add($key, $cacheable);
        return true;
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function delete($key)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        $item = $this->zzzCache->remove($key);
        return ! is_null($item);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        $this->zzzCache->clear();
        return true;
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys    A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     *
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $keys is neither an array nor a Traversable,
     *   or if any of the $keys are not a legal value.
     */
    public function getMultiple($keys, $default = null)
    {
        $this->triggerExceptionOnKeysNotArray($keys);

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->get($key);
        }

        return $items;
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable               $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|\DateInterval $ttl    Optional. The TTL value of this item. If no value is sent and
     *                                       the driver supports TTL then the library may set a default value
     *                                       for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $values is neither an array nor a Traversable,
     *   or if any of the $values are not a legal value.
     */
    public function setMultiple($values, $ttl = null)
    {
        $this->triggerExceptionOnKeysNotArray($values);
        $status = true;
        foreach($values as $key => $value) {
            $status = $this->set($key, $value, $ttl) && $status;
        }
        return $status;
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $keys is neither an array nor a Traversable,
     *   or if any of the $keys are not a legal value.
     */
    public function deleteMultiple($keys)
    {
        $this->triggerExceptionOnKeysNotArray($keys);
        $status = true;
        foreach ($keys as $key) {
            $status = $this->delete($key) && $status;
        }
        return $status;
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * NOTE: It is recommended that has() is only to be used for cache warming type purposes
     * and not to be used within your live applications operations for get/set, as this method
     * is subject to a race condition where your has() will return true and immediately after,
     * another script can remove it making the state of your app out of date.
     *
     * @param string $key The cache item key.
     *
     * @return bool
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public function has($key)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        return $this->zzzCache->has($key);
    }
}
