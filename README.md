# About SlimCache

a PHP simple cache implemention.

# Installation

Run through composer

    $ composer require juhara/tinycache

# How to use

    <?php

    use Juhara\TinyCache\Cache;
    use Juhara\TinyCache\Storages\File;
    use Juhara\TinyCache\Helpers\TimeUtility;
    use Juhara\TinyCache\Helpers\Md5Hash;

    $cache = new Cache(
        new File(
            new Md5Hash(),
            'app/storages/cache/',
            'cache'
        ),
        new TimeUtility()
    );

    $cache->add('itemNeedToBeCache', $cacheAbleItem);

    $cachedData = $cache->get('itemNeedToBeCache');
