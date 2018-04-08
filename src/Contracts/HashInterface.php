<?php

namespace Juhara\ZzzCache\Contracts;

/**
 * interface for any class capable of hashing string
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
interface HashInterface
{
    /**
     * hash data
     * @param  string $data data to hash
     * @return string hashed data
     */
    public function hash($data);
}
