<?php
namespace Juhara\ZzzCache\Tests\Helpers;

use Juhara\ZzzCache\Helpers\TimeUtility;
use PHPUnit\Framework\TestCase;

/**
 * TimeUtility implementation test
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class TimeUtilityTest extends TestCase
{
    public function testCurrentTimeStampIsCorrect()
    {
        $timeUtil = new TimeUtility();
        $currentTimestamp = round(microtime(true) * 1000);
        $timeStamp = $timeUtil->currentTimestamp();
        $this->assertEquals($timeStamp, $currentTimestamp);
    }

    public function testExpiryIsCorrect()
    {
        $ttl = 20000;
        $timeUtil = new TimeUtility();
        $currentExpiry = round(microtime(true) * 1000) + $ttl;
        $expiry = $timeUtil->expiry($ttl);
        $this->assertEquals($expiry, $currentExpiry);
    }

    public function testShouldBeExpired()
    {
        $timeUtil = new TimeUtility();
        $timeStamp = round(microtime(true) * 1000) - 10000;
        $this->assertEquals($timeUtil->expired($timeStamp), true);
    }

    public function testShouldNotBeExpired()
    {
        $timeUtil = new TimeUtility();
        $timeStamp = round(microtime(true) * 1000) + 1000;
        $this->assertEquals($timeUtil->expired($timeStamp), false);
    }
}
