<?php

namespace Support\RandomProxies;

use Carbon\Carbon;
use Support\RandomProxies\Contracts\CanParseRandomProxiesHtml;
use Support\RandomProxies\DTOs\ProxyDTO;
use Support\Traits\HasHtmlParsing;
use Symfony\Component\DomCrawler\Crawler;

class RandomProxiesParser implements CanParseRandomProxiesHtml
{
    use HasHtmlParsing;

    public const _GUID_KEY_KEY = "key";
    public const _GUID_KEY_SELECTOR = "selector";
    public const _GUID_KEY_ATTRIBUTE = "attribute";
    public const _GUID_KEY_CALLBACK = "callback";
    public const _GUID_KEY_PATTERN = "pattern";
    public const _GUID_KEY_MATCH_INDEX = "matchIndex";

    public const _RAW_KEY_IP = "ip";
    public const _RAW_KEY_PORT = "port";
    public const _RAW_KEY_COUNTRY_CODE = "countryCode";
    public const _RAW_KEY_COUNTRY = "country";
    public const _RAW_KEY_ANONYMITY = "anonymity";
    public const _RAW_KEY_IS_GOOGLE = "isGoogle";
    public const _RAW_KEY_IS_HTTPS = "isHttps";
    public const _RAW_KEY_LAST_CHECKED = "lastChecked";

    /**
     * Third party library parser
     *
     * @var Crawler
     * */
    protected $crawler;

    public function __construct(string $html)
    {
        $this->crawler = new Crawler($html);

        $this->parsingGuid = [
            self::_RAW_KEY_IP => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IP,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(1)",
            ],
            self::_RAW_KEY_PORT => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_PORT,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(2)",
            ],
            self::_RAW_KEY_COUNTRY_CODE => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_COUNTRY_CODE,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(3)",
            ],
            self::_RAW_KEY_COUNTRY => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_COUNTRY,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(4)",
            ],
            self::_RAW_KEY_ANONYMITY => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_ANONYMITY,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(5)",
            ],
            self::_RAW_KEY_IS_GOOGLE => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IS_GOOGLE,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(6)",
            ],
            self::_RAW_KEY_IS_HTTPS => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IS_HTTPS,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(7)",
            ],
            self::_RAW_KEY_LAST_CHECKED => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_LAST_CHECKED,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(8)",
            ],
        ];

        $this->initRawresult();
        $this->initParsingGuid();
    }

    /**
     * Parse html string, format into entries and return array of random proxies entries
     *
     * @return ProxyDTO[]
     * */
    public function parseRandomProxies(): array
    {
        if (! $this->getHtml()) {
            $this->result = [];
        }

        if ($this->result === null) {
            $this->parseRawResult();
            $this->rawResultToEntries();
        }

        return $this->result;
    }

    public function rawResultToEntries()
    {
        foreach ($this->rawResult as $item) {
            $this->result[] = new ProxyDTO([
                'ip' => (string)$item[static::_RAW_KEY_IP],
                'port' => (int)$item[static::_RAW_KEY_PORT],
                'countryCode' => (string)$item[static::_RAW_KEY_COUNTRY_CODE],
                'country' => (string)$item[static::_RAW_KEY_COUNTRY],
                'anonymity' => (string)$item[static::_RAW_KEY_ANONYMITY],
                'isGoogle' => $item[static::_RAW_KEY_IS_GOOGLE] === "yes",
                'isHttps' => $item[static::_RAW_KEY_IS_HTTPS] === "yes",
                'lastChecked' => Carbon::parse($item[static::_RAW_KEY_LAST_CHECKED]),
            ]);
        }
    }
}
