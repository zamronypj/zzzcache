<?php

namespace Juhara\ZzzCache\Psr;

use Juhara\ZzzCache\Psr\Contracts\CacheItemFactoryInterface;

/**
 * CacheItemInterface factory implementation which create instance
 * of AdapterCacheItem
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class AdapterCacheItemFactory implements CacheItemFactoryInterface
{
    /**
     * create CacheItemInterface interface instance from Cacheable
     *
     * @param Cacheable $cacheable cache item instance
     * @param string $key key name
     * @return Psr\Cache\CacheItemInterface new instance of CacheItemInterface interface
     */
    public function build(Cacheable $cacheable, $key)
    {
        return new AdapterCacheItem($cacheable, $key);
    }
}
