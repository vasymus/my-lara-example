<?php

namespace Support\RandomProxies\Repositories;

use Support\RandomProxies\Contracts\CanGetRandomProxies;
use Support\RandomProxies\DTOs\ProxyDTO;

class RandomProxiesRepository implements CanGetRandomProxies
{
    /**
     * @var \Support\RandomProxies\DTOs\ProxyDTO[]
     * */
    protected $store;

    /**
     * @param \Support\RandomProxies\DTOs\ProxyDTO[] $store
     * */
    public function __construct(array $store = [])
    {
        $this->store = $store;
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
     * @return \Support\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function getAllRandomProxies(): array
    {
        return collect($this->store)
            ->sort(function (ProxyDTO $a, ProxyDTO $b) {
                return $b->lastChecked->getTimestamp() - $a->lastChecked->getTimestamp();
            })
            ->values()
            ->toArray()
        ;
    }
}
