<?php
namespace system\cache\driver;

use system\cache\CacheDriver;

/**
 * Class MemcacheDriver
 * @package system\cache\driver
 */
class NullCacheDriver extends CacheDriver
{
    /**
     * @var \Memcache
     */
    private $_memcache;

    /**
     * @param array $config
     * @return bool
     */
    public function init(array $config)
    {
    }

    /**
     * @param $cacheLabel
     * @return array|mixed|null|string
     * @todo remove host prefix when deploying
     */
    public function load($cacheLabel)
    {
    }

    /**
     * @param $cacheLabel
     * @param $cacheData
     * @param null $expire
     * @return bool
     * @todo remove host prefix when deploying
     */
    public function save($cacheLabel, $cacheData, $expire = null)
    {
    }

    /**
     * @param $cacheLabel
     * @return bool
     * @todo remove host prefix when deploying
     */
    public function test($cacheLabel)
    {
    }

    /**
     *
     * @return bool
     */
    public function flush()
    {
    }
}