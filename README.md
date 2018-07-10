# About ZzzCache
A PHP minimalist and simple cache implementation.

# Requirement
- [PHP >= 5.4](https://php.net)
- [Composer](https://getcomposer.org)

# Installation
Run through composer

    $ composer require juhara/zzzcache

# How to use

### Implement Cacheable interface

Any class that can be stored in cache manager needs to implements `Cacheable` interface, which is `data()` and `ttl()` method.

- `data()` method should return class data.
- `ttl()` should return integer value of time to live in millisecond. This value determine how long data will be kept in cache until considered expired.

When reading data from cache, cache manager relies on cache storage interface implementation to provide proper serialization/unserialization when read owr write data.

There is one `Cacheable` implementation provided, `ClosureCacheable` class, which implements data as closure.

    $ttl = 60*60*1; //cache item for 1 hour
    $cacheableItem = new ClosureCacheable(function () {
        return [
            'dummyData' => 'dummy data'
        ];
    }, $ttl);

When `$cacheableItem->data()` is called, it call closure function pass in constructor and return data that defiend in closure.

Of course, you are free to implement your own.

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

# Contributing

Just create PR if you want to improve it.

Thank you.
