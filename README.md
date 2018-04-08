# About SlimCache

a PHP simple cache implemention.

# Installation

Run through composer

    $ composer require juhara/slimcache

# How to use

    <?php

    use Juhara\SlimCache\Cache;
    use Juhara\SlimCache\Storages\File;
    use Juhara\SlimCache\Helpers\TimeUtility;
    use Juhara\SlimCache\Helpers\Md5Hash;

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
