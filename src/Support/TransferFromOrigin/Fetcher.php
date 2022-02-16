<?php

namespace Support\TransferFromOrigin;

use Campo\UserAgent;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;
use Support\RandomProxies\Contracts\CanGetRandomProxies;
use Support\RandomProxies\Repositories\RandomProxiesCacheRepository;
use Support\RandomProxies\Repositories\RandomProxiesRepository;

class Fetcher
{
    protected $url;

    protected $username;

    protected $password;

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null|mixed
     * */
    public function fetch()
    {
        if (! $this->url) {
            throw new \LogicException("Fetch url is not provided");
        }

        /** @var Builder $builder */
        $builder = Curl::to($this->url);
        $builder->withOption('USERPWD', "{$this->username}:{$this->password}");
        $headers = [];

        try {
            $headers[] = "User-Agent: " . UserAgent::random();
        } catch (\Exception $exc) {
        }
//        if (!empty($headers)) $builder->withHeaders($headers);
//        $this->addRandomProxy($builder);
//
//        $builder->enableDebug(storage_path("/logs/curl1.log"));

        return $builder->get();
    }

    protected function addRandomProxy(Builder $builder)
    {
        /** @var CanGetRandomProxies | RandomProxiesCacheRepository | RandomProxiesRepository $proxies */
        $proxies = resolve(CanGetRandomProxies::class);
        $randomProxy = $proxies->getOneRandomProxy();

        if ($randomProxy) {
            $builder->withProxy($randomProxy->ip, (string)$randomProxy->port);
        }
    }
}
