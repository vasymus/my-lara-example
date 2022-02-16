<?php

namespace Support\RandomProxies;

use Illuminate\Support\ServiceProvider;
use Support\RandomProxies\Contracts\CanFetchRandomProxiesHtml;
use Support\RandomProxies\Contracts\CanGetRandomProxies;
use Support\RandomProxies\Contracts\CanParseRandomProxiesHtml;
use Support\RandomProxies\Repositories\RandomProxiesCacheRepository;
use Support\RandomProxies\Repositories\RandomProxiesRepository;

class RandomProxiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CanFetchRandomProxiesHtml::class, RandomProxiesHtmlFetcher::class);

        $this->app->bind(CanParseRandomProxiesHtml::class, function () {
            /** @var CanFetchRandomProxiesHtml | RandomProxiesHtmlFetcher $fetcher */
            $fetcher = resolve(CanFetchRandomProxiesHtml::class);

            return new RandomProxiesParser(
                $fetcher->fetchRandomProxiesHtml()
            );
        });

        $this->app->bind(CanGetRandomProxies::class, function () {
            /** @var CanParseRandomProxiesHtml | RandomProxiesParser $parser */
            $parser = resolve(CanParseRandomProxiesHtml::class);

            $repo = new RandomProxiesRepository($parser->parseRandomProxies());

            return new RandomProxiesCacheRepository(
                $repo
            );
        });
    }
}
