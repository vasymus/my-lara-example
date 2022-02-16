<?php

namespace Support\RandomProxies;

use Support\RandomProxies\Contracts\CanFetchRandomProxiesHtml;
use Support\Traits\CanFetchHtml;

class RandomProxiesHtmlFetcher implements CanFetchRandomProxiesHtml
{
    use CanFetchHtml;

    /**
     * @var string Url for fetching html for parse
     * */
    protected $url;

    public function __construct()
    {
        $this->url = collect(config("services.random-proxies"))->get("url");
    }

    /**
     * @return string
     */
    public function fetchRandomProxiesHtml()
    {
        return $this->prepareFetch($this->url)->addUserAgent()->execFetch();
    }
}
