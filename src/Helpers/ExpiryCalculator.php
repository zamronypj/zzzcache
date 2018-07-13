<?php
namespace Juhara\ZzzCache\Helpers;

use Juhara\ZzzCache\Contracts\ExpiryCalculatorInterface;

/**
 * helper class for timestamp calculation
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class ExpiryCalculator implements ExpiryCalculatorInterface
{
    /**
     * get current unix timestamp
     * @return int current timestamp
     */
    private function currentTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * get expiry timestamp relative to current timestamp
     * @param  int $ttl time to live
     * @return int expiry timestamp
     */
    public function expiry($ttl)
    {
        return $this->currentTimestamp() + $ttl;
    }

    /**
     * test if a timestamp is expired (i.e in the past)
     * @param  int $timestamp timestamp to check
     * @return boolean true if expired
     */
    public function expired($timestamp)
    {
        return $this->currentTimestamp() > $timestamp;
    }
}
