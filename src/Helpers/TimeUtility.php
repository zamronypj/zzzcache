<?php

namespace Juhara\ZzzCache\Helpers;

/**
 * helper class for timestamp calculation
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class TimeUtility
{
    public function currentTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    public function expiry($ttl)
    {
        return $this->currentTimestamp() + $ttl;
    }

    public function expired($timestamp)
    {
        return $this->currentTimestamp() > $timestamp;
    }
}
