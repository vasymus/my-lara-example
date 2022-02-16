<?php

namespace Support\RandomProxies\Contracts;

interface CanParseRandomProxiesHtml
{
    /**
     * Return array of random proxies
     * @return \Support\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function parseRandomProxies(): array;
}
