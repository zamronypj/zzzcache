<?php
namespace Juhara\ZzzCache\Psr;

use Psr\Cache\CacheItemPoolInterface;
use Juhara\ZzzCache\Contracts\CacheInterface;
use Juhara\ZzzCache\Psr\Contracts\CacheItemFactoryInterface;

/**
 * CacheItemPoolInterface implementation to support PSR-6 Caching Interface.
 *
 * @link https://www.php-fig.org/psr/psr-6/
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class AdapterCachePool extends BaseAdapter implements CacheItemPoolInterface
{
    /**
     * zzzcache instance
     * @var Juhara\ZzzCache\Contracts\CacheInterface
     */
    private $zzzCache;

    /**
     * CacheItemInterface factory
     *
     * @var Juhara\ZzzCache\Psr\Contracts\CacheItemFactoryInterface
     */
    private $factory;

    private $items = [];

    public function __construct(
        CacheInterface $cache,
        CacheItemFactoryInterface $factory
    ) {
        $this->zzzCache = $cache;
        $this->factory = $factory;
    }

    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return a CacheItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key
     *   The key for which to return the corresponding Cache Item.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return CacheItemInterface
     *   The corresponding Cache Item.
     */
    public function getItem($key)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        $item = $this->zzzCache->get($key);
        return $this->factory->build($cacheable, $key);
    }

    /**
     * Returns a traversable set of cache items.
     *
     * @param string[] $keys
     *   An indexed array of keys of items to retrieve.
     *
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return array|\Traversable
     *   A traversable collection of Cache Items keyed by the cache keys of
     *   each item. A Cache item will be returned for each key, even if that
     *   key is not found. However, if no keys are specified then an empty
     *   traversable MUST be returned instead.
     */
    public function getItems(array $keys = array())
    {
        $this->triggerExceptionOnKeysNotArray($keys);

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }

        return $items;
    }

    /**
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with CacheItemInterface::get(). To avoid
     * such situation use CacheItemInterface::isHit() instead.
     *
     * @param string $key
     *   The key for which to check existence.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if item exists in the cache, false otherwise.
     */
    public function hasItem($key)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        return $this->zzzCache->has($key);
    }

    /**
     * Deletes all items in the pool.
     *
     * @return bool
     *   True if the pool was successfully cleared. False if there was an error.
     */
    public function clear()
    {
        $this->zzzCache->clear();
        return true;
    }

    /**
     * Removes the item from the pool.
     *
     * @param string $key
     *   The key to delete.
     *
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the item was successfully removed. False if there was an error.
     */
    public function deleteItem($key)
    {
        $this->triggerExceptionOnInvalidKeyFormat($key);
        $item = $this->zzzCache->remove($key);
        return ! is_null($item);
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param string[] $keys
     *   An array of keys that should be removed from the pool.

     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     *
     * @return bool
     *   True if the items were successfully removed. False if there was an error.
     */
    public function deleteItems(array $keys)
    {
        $this->triggerExceptionOnKeysNotArray($keys);

        $status = true;
        foreach ($keys as $key) {
            $status = $this->deleteItem($key) && $status;
        }

        return $status;
    }

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item)
    {
        //TODO: implement this
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        //TODO: implement this
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool
     *   True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     */
    public function commit()
    {
        //TODO: implement this
    }
}
