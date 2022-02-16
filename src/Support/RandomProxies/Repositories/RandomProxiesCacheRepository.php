<?php

namespace Support\RandomProxies\Repositories;

use Illuminate\Support\Facades\Cache;
use Support\RandomProxies\Contracts\CanGetRandomProxies;
use Support\RandomProxies\DTOs\ProxyDTO;

class RandomProxiesCacheRepository implements CanGetRandomProxies
{
    public const C_PREFIX = "random-proxies-";

    public const C_TIME = 30; // seconds

    /**
     * @var RandomProxiesRepository
     * */
    protected $repo;

    public static function getAllCacheKey(): string
    {
        return static::C_PREFIX . "all";
    }

    public static function getAllCacheTime(): \Illuminate\Support\Carbon
    {
        return now()->addSeconds(static::C_TIME);
    }

    public function __construct(RandomProxiesRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return \Support\RandomProxies\DTOs\ProxyDTO
     * */
    public function getOneRandomProxy(): ?ProxyDTO
    {
        $all = $this->getAllRandomProxies();
        if (empty($all)) {
            return null;
        }

        return collect($all)->take(20)->random();
    }

    /**
     * @return ProxyDTO[]
     * */
    public function getAllRandomProxies(): array
    {
        return Cache::remember(static::getAllCacheKey(), static::getAllCacheTime(), function () {
            return $this->repo->getAllRandomProxies();
        });
    }
}
