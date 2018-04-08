<?php
namespace Juhara\ZzzCache\Tests\Helpers;

use Juhara\ZzzCache\Helpers\Md5Hash;
use PHPUnit\Framework\TestCase;

/**
 * basic MD5 hash implementation
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
final class Md5HashTest extends TestCase
{
    /**
     * hash data
     * @param  string $data data to hash
     * @return string hashed data
     */
    public function testVerifyHashUsingMd5()
    {
        $inputString = 'We Love You';
        $md5Hash =  new Md5Hash();
        $hashData = $md5Hash->hash($inputString);
        $this->assertEquals(md5($inputString), $hashData);
    }
}
