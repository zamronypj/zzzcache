<?php

namespace Juhara\TinyCache\Helpers;

use Juhara\TinyCache\Contracts\HashInterface;

/**
 * basic MD5 hash implementation
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
class Md5Hash implements HashInterface
{
    /**
     * hash data
     * @param  string $data data to hash
     * @return string hashed data
     */
    public function hash($data)
    {
        return md5($data);
    }
}
