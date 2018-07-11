# About ZzzCache
A minimalist and simple PHP cache library implementation. Visit
[Documentation](https://v3.juhara.com/zzzcache.html) for more information.

# Requirement
- [PHP >= 5.4](https://php.net)
- [Composer](https://getcomposer.org)

# Installation
Run through composer

    $ composer require juhara/zzzcache

# How to use

### Implement Cacheable interface

Any class that can be stored in cache manager needs to implements `Juhara\ZzzCache\Contracts\Cacheable` interface, which is `data()` and `ttl()` method.

- `data()` method should return class data.
- `ttl()` should return integer value of time to live in millisecond. This value determine how long data will be kept in cache until considered expired.

When reading data from cache, cache manager relies on cache storage interface implementation to provide proper serialization/unserialization when read or write data.

There is one `Juhara\ZzzCache\Contracts\Cacheable` implementation provided, `ClosureCacheable` class, which implements data as closure.

    $ttl = 60 * 60 * 1; //cache item for 1 hour
    $cacheableItem = new Juhara\ZzzCache\Helpers\ClosureCacheable(function () {
        return [
            'dummyData' => 'dummy data'
        ];
    }, $ttl);

When `$cacheableItem->data()` is called, it calls closure function pass in constructor and return data that defined in closure.

Of course, you are free to implement your own.

### Initialize Cache instance

`Juhara\ZzzCache\Cache` class is default `Juhara\ZzzCache\Contracts\CacheInterface`
implementation provided with this library.

To use it, you need to provide `Juhara\ZzzCache\Contracts\CacheStorageInterface`
 and `Juhara\ZzzCache\Contracts\ExpiryCalculatorInterface` implementation.

See [Storage Implementation](#storage-implementation) for available `CacheStorageInterface` implementation.

There is `Juhara\ZzzCache\Helpers\TimeUtility` class which is default `ExpiryCalculatorInterface` implementation for this library. See [Example](#example)

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

# Storage Implementation
Caches need to be stored somewhere. ZzzCache does not implement storage interface.
It delegates this to separate library to provide storage implementation,
so developer can use storage implementation that suits their needs only.
Currently supported implementation is file-based and Redis-based storage.

### File-based Storage

To install, run composer

    $ composer require juhara/zzzfile

See [zzzfile](https://github.com/zamronypj/zzzfile).

### Redis-based Storage

To install, run composer

    $ composer require juhara/zzzredis

See [zzzredis](https://github.com/zamronypj/zzzredis).

# Example

Using file as cache storage with [zzzfile](https://github.com/zamronypj/zzzfile).

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

Using Redis as cache storage with [zzzredis](https://github.com/zamronypj/zzzredis).

    <?php

    use Juhara\ZzzCache\Cache;
    use Juhara\ZzzCache\Storages\Redis;
    use Juhara\ZzzCache\Helpers\TimeUtility;

    // create a redis-based cache
    $cache = new Cache(
        new Redis(new \Predis\Client()),
        new TimeUtility()
    );

To get data from cache if available or from slower storage.

    <?php

    ...

    try {
        //try to get data from cache if available
        $cachedData = $cache->get('itemNeedToBeCache');        
    } catch (\Juhara\ZzzCache\Exceptions\CacheNameNotFound $e) {
        $acacheableItem = new \Juhara\ZzzCache\Helpers\ClosureCacheable(
            function () {
                //get data from slower storage
                return ['dummyData'=>'dummyData'];
            },
            60 * 60 * 1 //cache item for 1 hour
        );
        $cachedData = $cache->add('itemNeedToBeCache', $acacheableItem)
                            ->get('itemNeedToBeCache');
    }


# Contributing

Just create PR if you want to improve it.

Thank you.
