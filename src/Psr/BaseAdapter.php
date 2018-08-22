<?php

namespace Juhara\ZzzCache\Psr;

use Psr\SimpleCache\InvalidArgumentException as PsrInvalidArgumentException;

/**
 * Base adapter class implementation that provides common methods for
 * PSR-6 Caching Interface and PSR-16 CacheInterface
 *
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */
class BaseAdapter
{
    /**
     * test if key len format is valid according to PSR-6 requirement
     * which is UTF-8 code up to 64 characters consisting of combination of
     * alphanumeric, underscore and dot characters.
     * @param  string  $key key name
     * @return boolean      true if key is valid, false otherwise
     */
    private function isLegalKeyFormat($key)
    {
        $len = strlen($key);
        return ($len > 0) &&
            ($len <= 64) &&
            (preg_match('/[a-zA-Z0-9\.\_]+/', $key) === 1);
    }

    /**
     * trigger exception if key name is invalid
     * @param  string $key key name
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * if key is invalid
     */
    protected function triggerExceptionOnInvalidKeyFormat($key)
    {
        if (! $this->isLegalKeyFormat($key)) {
            throw new PsrInvalidArgumentException('Invalid key name');
        }
    }

    /**
     * trigger exception if keys is not array
     * @param  array $keys array of key name
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * if keys is not array
     */
    protected function triggerExceptionOnKeysNotArray($keys)
    {
        if (! is_array($keys)) {
            throw new PsrInvalidArgumentException('Input must be array');
        }
    }

}
