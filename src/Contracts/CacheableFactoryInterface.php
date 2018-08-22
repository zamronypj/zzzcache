<?php

namespace Juhara\ZzzCache\Contracts;

/**
 * interface for any class that can create Cachable interface instance
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface CacheableFactoryInterface
{
    /**
     * create Cacheable interface instance
     * @param mixed $value data to be stored in Cacheable instance
     * @param int   $ttl   time to live
     * @return Cacheable new instance of Cacheable interface
     */
    public function build($value, $ttl);
}
