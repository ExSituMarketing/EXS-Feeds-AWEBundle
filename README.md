# EXS-FeedsAWEBundle

[![Build Status](https://travis-ci.org/ExSituMarketing/EXS-FeedsAWEBundle.svg?branch=master)](https://travis-ci.org/ExSituMarketing/EXS-FeedsAWEBundle)

## Installation

This bundle uses [PHP's native Memcached objects](http://php.net/manual/en/class.memcached.php).

**Make sure the memcached module is enabled in your PHP's installation.**

Require the bundle using composer
```
$ composer require exs/feeds-awe-bundle
```

Enable it in your application's AppKernel
```php
<?php
// app/AppKernel.php

class AppKernel extends Kernel
{
    // ...
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new EXS\FeedsAWEBundle\EXSFeedsAWEBundle(),
        );
    }
}
```

## Configuration

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

A command is also available if you want to force refresh the memcached record.

```bash
$ app/console feeds:awe:refresh-live-performers --env=prod --no-debug
```
