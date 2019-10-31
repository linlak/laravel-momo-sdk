<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;

class Cache
{
    /**
     * Instance of cache manager.
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * Lifetime of the cache.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new cache instance.
     *
     * @param CacheManager $cache
     * @param array        $tags
     * @param int          $expires
     */
    public function __construct(CacheManager $cache, $tags, $expires = 5)
    {
        $this->cache = ($tags) ? $cache->tags($tags) : $cache;
        $this->expires = $expires;
    }

    /**
     * Get an item from the cache.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get($name)
    {
        $value = $this->cache->get($name);

        return $value;
    }

    /**
     * Store an item in cache.
     *
     * @param string   $name
     * @param string $location
     * @param int $expires
     *
     * @return bool
     */
    public function set($name, $access_token, $expires)
    {
        return $this->cache->put($name, $access_token, ($expires > $this->expires) ? floor($expires / 60) - $this->expires : $this->expires);
    }
    /**
     * Flush cache for tags.
     *
     * @return bool
     */
    public function flush()
    {
        return $this->cache->flush();
    }
}
