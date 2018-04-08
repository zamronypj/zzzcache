# About ZzzCache
A PHP minimalist and simple cache implemention.

# Requirement
- [PHP >= 5.4](https://php.net)
- [Composer](https://getcomposer.org)

# Installation
Run through composer

    $ composer require juhara/zzzcache

# How to use

### Implement Cacheable interface

Any class that can be stored in cache manager needs to implements `Cacheable` interface, which is `data()` and `ttl()` method.

- `data()` method should return class data as serialized string.
- `ttl()` should return integer value of time to live in millisecond. This value determine how long data will be kept in cache until considered expired.

When reading data from cache, cache manager return string as it is. It is up to caller to handle how to serialize it back into original class.

### Initialize Cache instance

    <?php

    use Juhara\ZzzCache\Cache;
    use Juhara\ZzzCache\Storages\File;
    use Juhara\ZzzCache\Helpers\TimeUtility;
    use Juhara\ZzzCache\Helpers\Md5Hash;

    // create a file-based cache where all cache
    // files is stored in directory name
    // app/storages/cache with
    // filename prefixed with string 'cache'
    $cache = new Cache(
        new File(
            new Md5Hash(),
            'app/storages/cache/',
            'cache'
        ),
        new TimeUtility()
    );
    $acacheableItem = new ClassThatImplementCacheable();
    $cache->add('itemNeedToBeCache', $cacheAbleItem);

    $cachedData = $cache->get('itemNeedToBeCache');

## Issue and Improvement contribution

Just create PR if you want to improve it. Thank you.
