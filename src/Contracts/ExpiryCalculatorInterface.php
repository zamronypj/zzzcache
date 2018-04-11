<?php
namespace Juhara\ZzzCache\Contracts;

/**
 * interface for class providing expiry calculation
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface ExpiryCalculatorInterface
{
    /**
     * calculate expiry from time to live
     * @param  int $ttl time to live in millisecond
     * @return int expiry in millisecond
     */
    public function expiry($ttl);

    /**
     * test if timestamp is expired or not
     * @param  int $timestamp timestamp in millisecond
     * @return boolean true if expired or false otherwise
     */
    public function expired($timestamp);
}
