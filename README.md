[![Build Status](https://api.travis-ci.org/felixarntz/wp-psr-cache.png?branch=master)](https://travis-ci.org/felixarntz/wp-psr-cache)
[![Code Climate](https://codeclimate.com/github/felixarntz/wp-psr-cache/badges/gpa.svg)](https://codeclimate.com/github/felixarntz/wp-psr-cache)
[![Test Coverage](https://codeclimate.com/github/felixarntz/wp-psr-cache/badges/coverage.svg)](https://codeclimate.com/github/felixarntz/wp-psr-cache/coverage)
[![Latest Stable Version](https://poser.pugx.org/felixarntz/wp-psr-cache/version)](https://packagist.org/packages/felixarntz/wp-psr-cache)
[![License](https://poser.pugx.org/felixarntz/wp-psr-cache/license)](https://packagist.org/packages/felixarntz/wp-psr-cache)

# WP PSR Cache

Object cache implementation for WordPress that acts as an adapter for PSR-6 and PSR-16 caching libraries.

## What do PSR-6 and PSR-16 mean?

[PSR-6](http://www.php-fig.org/psr/psr-6/) and [PSR-16](http://www.php-fig.org/psr/psr-16/) are standards established by the [PHP-FIG](http://www.php-fig.org/) organization. These standards are commonly used in PHP projects of any kind (WordPress is unfortunately an exception), and since this library acts as an adapter, you can use any compatible caching library of your choice with WordPress now. Popular examples include the [Symfony Cache Component](https://github.com/symfony/cache) or [Stash](https://github.com/tedious/Stash).

## How to Install

Require this library as a dependency when managing your project with Composer (for example by using [Bedrock](https://github.com/roots/bedrock)). You also have to install an actual [PSR-6](https://packagist.org/providers/psr/cache-implementation) or [PSR-16](https://packagist.org/providers/psr/simple-cache-implementation) cache implementation.

After the installation, you need to move the `includes/object-cache.php` file into your `wp-content` directory. If you prefer, you can also automate that process by adding the following to your project's `composer.json`:

```
	"scripts": {
		"post-install-cmd": [
			"cp -rp web/app/mu-plugins/wp-psr-cache/includes/object-cache.php web/app/object-cache.php"
		]
	}
```

Then, replace the inline comments in the `object-cache.php` file with the actual instantiations of the classes you want to use. You need to provide two implementations, one for the persistent cache and another for the non-persistent cache.

### Example

The following example uses the `symfony/cache` library, so you have to require it in your `composer.json`. It then uses that library's Memcached implementation as persistent cache and its array storage as non-persistent cache.

```php
<?php
/**
 * Object cache drop-in
 *
 * @package LeavesAndLove\WpPsrCache
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/wp-psr-cache
 */

use LeavesAndLove\WpPsrCache\ObjectCacheService;
use LeavesAndLove\WpPsrCache\CacheAdapter\PsrCacheAdapterFactory;
use Symfony\Component\Cache\Simple\MemcachedCache;
use Symfony\Component\Cache\Simple\ArrayCache;

defined( 'ABSPATH' ) || exit;

ObjectCacheService::loadApi();

/**
 * Defines and thus starts the object cache.
 *
 * @since 1.0.0
 */
function wp_psr_start_cache() {
    $factory = new PsrCacheAdapterFactory();

    $memcached = new Memcached();
	$memcached->addServer( '127.0.0.1', 11211, 20 );

    $persistentCache    = $factory->create( new MemcachedCache( $memcached ) );
    $nonPersistentCache = $factory->create( new ArrayCache() );

    ObjectCacheService::startInstance( $persistentCache, $nonPersistentCache );
}

wp_psr_start_cache();

```

## Requirements

* PHP >= 7.0
