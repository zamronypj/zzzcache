<?php

namespace Juhara\SlimCache\Contracts;

/**
 * interface for any class that can be stored in cache
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface Cacheable
{
    /**
     * get data in serialized format
     * @return string data in serialized format
     */
    public function data();

    /**
     * retrieve time to live in millisecond
     * @return [int] time to live of cache
     */
    public function ttl();
}
