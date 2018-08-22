<?php

namespace Juhara\ZzzCache\Psr\Contracts;

use Juhara\ZzzCache\Contracts\Cacheable;

/**
 * interface for any class that can create CacheItemInterface interface instance
 * from Cacheable interface
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface CacheItemFactoryInterface
{
    /**
     * create CacheItemInterface interface instance from Cacheable
     *
     * @param Cacheable $cacheable cache item instance
     * @param string $key key name
     * @return Psr\Cache\CacheItemInterface new instance of CacheItemInterface interface
     */
    public function build(Cacheable $cacheable, $key);
}
