<?php

namespace Lira\Application;

use Lira\Framework\Cache\CacheInterface;

class Cache implements CacheInterface
{
    protected ?\Memcached $memcached;

    public function __construct(protected string $host='localhost',protected int $port=11211)
    {
    }

    public function init(): void
    {
        if(is_null($this->memcached)){
            $this->memcached = new \Memcached();
            $this->memcached->addServer($this->host,$this->port);
        }
    }

    public function connect()
    {
        return $this->memcached;
    }
}