<?php

namespace Juhara\ZzzCache\Helpers;

use Juhara\ZzzCache\Contracts\CacheableFactoryInterface;

/**
 * Cacheable factory implementation which create instance of ClosureCacheable
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class ClosureCacheableFactory implements CacheableFactoryInterface
{
    /**
     * create Cacheable interface instance
     * @param mixed $value data to be stored in Cacheable instance
     * @param int   $ttl   time to live
     * @return Cacheable new instance of Cacheable interface
     */
    public function build($value, $ttl)
    {
        return new ClosureCacheable(
            function () use ($value) {
                return $value;
            },
            $ttl
        );
    }
}
