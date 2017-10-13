# EXS-FeedsAWEBundle

## Install

Require the bundle from packagist
```
$ composer require exs/feeds-awe-bundle
```

Enable the bundle in AppKernel
```php
<?php
...
class AppKernel extends Kernel
{
    ...
    public function registerBundles()
    {
        $bundles = array(
            ...
            new EXS\FeedsAWEBundle\EXSFeedsAWEBundle(),
        );
    }
    ...
}
```

## Config

Some configuration is available to manage the cache.

```yml
# Default values
exs_feeds_awe:
    cache_ttl: 300
    memcached_host: 'localhost'
    memcached_port: 11211
```

## Usage

```php
// Returns performer Ids' array.
$performerIds = $container
    ->get('exs_feeds_awe.feeds_reader')
    ->getLivePerformers()
;
```

A command is also available if you want to force refresh the cache.

```bash
$ app/console feeds:awe:refresh-live-performers --env=prod --no-debug
```
