<?php

namespace Support\RandomProxies\Contracts;

use Support\RandomProxies\DTOs\ProxyDTO;

interface CanGetRandomProxies
{
    /**
     * @return \Support\RandomProxies\DTOs\ProxyDTO
     * */
    public function getOneRandomProxy(): ?ProxyDTO;

    /**
     * @return \Support\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function getAllRandomProxies(): array;
}
