<?php

namespace Juhara\ZzzCache\Helpers;

use Juhara\ZzzCache\Contracts\Cacheable;

/**
 * Cacheable implementation which use closure to get data
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
class ClosureCacheable implements Cacheable
{
    /**
     * callable that is call when data is needed
     * @var callable
     */
    private $dataClosure;

    /**
     * time to live in unix timestamp
     * @var int
     */
    private $timeToLive;

    /**
     * constructor
     * @param callable $dataClosure callable
     * @param int   $timeToLive  timestamp
     */
    public function __construct(callable $dataClosure, $timeToLive)
    {
        $this->dataClosure = $dataClosure;
        $this->timeToLive = $timeToLive;
    }

    /**
     * get data in serialized format
     * @return string data in serialized format
     */
    public function data()
    {
        $func = $this->dataClosure;
        return $func();
    }

    /**
     * retrieve time to live in millisecond
     * @return int time to live of cache
     */
    public function ttl()
    {
        return $this->timeToLive;
    }
}
