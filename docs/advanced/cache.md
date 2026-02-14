---
sidebar_position: 1
---

# Cache

The framework includes an integrated Cache system, which is a wrapped/modified version of phpFastCache. It supports multiple storage types such as:

* Redis
* Predis
* Cookie
* Files **(default)**
* MemCache / MemCached
* APC / WinCache
* X-Cache

## Introduction

The Cache component provides a static interface for storing and retrieving values by key. It handles expiration times and allows simplified caching workflows in controllers, actions, or services.

Before using it, make sure the cache engine is configured in your application’s configuration (typically via config.php). If no cache configuration is provided, cache functionality will be disabled.

## Usage

### Import the class

```php
use WPMVC\Cache;
```

### Basic Operations

#### Get a cached value

Retrieve a stored cache value. If the key does not exist or the cache system is not enabled, this returns `null` (or a default if provided).

```php
$value = Cache::get( 'cache_key' );
$value = Cache::get( 'cache_key', 'default value' );
```

#### Check existence

Before retrieving a value, check whether it exists:

```php
if ( Cache::has( 'cache_key' ) ) {
    $value = Cache::get( 'cache_key' );
}
```

#### Add a value to cache

Store a value in cache for a given number of minutes.

```php
Cache::add( 'cache_key', $value, 10 ); // 10 minutes
```

#### Remember pattern

This retrieves a cached value if it exists. Otherwise, it runs the given callable to generate/store a value:

```php
$value = Cache::remember( 'cache_key', 10, function () {
    return expensive_computation();
});
```

#### Removing Data

Forget a cache key

```php
Cache::forget( 'cache_key' );
```

#### Flush all cache

Remove all cached entries:

```php
Cache::flush();
```

## Configuration

The cache system can be configured via your configuration file (example: `config/cache.php`). Typical configuration options include:

* which **storage engine** to use (files, Redis, etc.)
* **cache path** if using file storage
* **enabled/disabled** flag

If a configured path is not found and the engine uses files (e.g., `files` or `auto`), the directory will be created automatically.

The core cache instance is initialized on first use using the configuration and phpFastCache defaults, and it remains shared statically.

## Under the Hood

Behind the scenes:

* A single static instance of the phpFastCache engine is created.
* The static methods on `Cache` proxy to that instance.
* If cache is disabled via config, instance creation will mark caches disabled and `get()` / `has()` behave accordingly.

## Examples

Caching an expensive result

```php
use WPMVC\Cache;

$result = Cache::remember( 'expensive_query', 30, function () {
    return Model::findBigResult();
});
// $result is either from cache, or newly computed.
```

Conditional cache usage

```php
if ( Cache::has( 'recent_posts' ) ) {
    $posts = Cache::get( 'recent_posts' );
} else {
    $posts = Post::recent();
    Cache::add( 'recent_posts', $posts, 15 );
}
```

## Best practices

* Keys should be unique strings meaningful to your context.
* Expiration times are specified in minutes.
* Use `remember()` to simplify patterns where cache is recomputed only when necessary.