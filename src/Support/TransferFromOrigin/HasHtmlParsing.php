<?php

namespace Support\TransferFromOrigin;

use Symfony\Component\DomCrawler\Crawler;

trait HasHtmlParsing
{
    /** @var string */
    public $attribute;

    /**
     * Array of raw results from nodes not converted to entry object yet
     *
     * @var array
     * */
    protected $rawResult = [];

    /**
     * Final result of parsing
     *
     * @var array
     * */
    protected $result;

    /** @var array */
    public $parsingGuid;

    /**
     * Parse texts from instantiated \Symfony\Component\DomCrawler\Crawler instance
     *
     * @param string $selector
     *
     * @return string[]|null
     */
    public function parseText(string $selector): ?array
    {
        try {
            $result = $this->getCrawler()->filter($selector)->each(function (Crawler $node, $i) {
                return trim($node->text());
            });
        } catch (\Exception $exception) {
            $result = null;
        }

        return $result;
    }

    /**
     * Parse attributes from instantiated \Symfony\Component\DomCrawler\Crawler instance
     *
     * @param string $selector
     * @param string $attribute
     *
     * @return string[]|null
     * */
    public function parseAttribute(string $selector, string $attribute): ?array
    {
        $this->attribute = $attribute;

        try {
            $result = $this->getCrawler()->filter($selector)->each(function (Crawler $node, $i) {
                return trim($node->attr($this->attribute));
            });
        } catch (\Exception $exception) {
            $result = null;
        }

        return $result;
    }

    /**
     * Return instantiated \Symfony\Component\DomCrawler\Crawler instance
     *
     * @return Crawler|null
     * */
    public function getCrawler(): ?Crawler
    {
        return isset($this->crawler) ? $this->crawler : null;
    }

    /**
     * Return html string from instantiated \Symfony\Component\DomCrawler\Crawler instance
     *
     * @return string
     * */
    public function getHtml(): string
    {
        return $this->getCrawler()->html();
    }

    /**
     * Get line from raw html string
     * https://stackoverflow.com/a/14789147
     *
     * @param string $pattern
     *
     * @return string|null
     * */
    public function getFirstLine(string $pattern): ?string
    {
        $separator = "\r\n";
        $html = $this->getHtml();
        if (! $html) {
            return null;
        }

        $line = strtok($html, $separator);

        $lineResult = null;

        while ($line !== false) {
            if (preg_match($pattern, $line) === 1) {
                $lineResult = $line;

                break;
            }

            $line = strtok($separator);
        }

        return $lineResult;
    }

    protected function initRawresult()
    {
        $this->rawResult[] = array_fill_keys(array_keys($this->parsingGuid), null);
    }

    protected function initParsingGuid()
    {
        $this->setCbHandlers();
    }

    protected function setCbHandlers()
    {
    }

    /**
     * Standard callback handler for parsing raw key from html using parse guid item
     *
     * @param array $guid
     *
     * @return string[]|null
     * */
    public function stdHandler(array $guid): ?array
    {
        $parsed = null;
        $pattern = $guid[static::_GUID_KEY_PATTERN] ?? null;
        $matchIndex = $guid[static::_GUID_KEY_MATCH_INDEX] ?? null;

        $text = $this->stdParse($guid);

        if ($text && $pattern && ! is_null($matchIndex)) {
            foreach ($text as $item) {
                if (preg_match($pattern, $item, $matches)) {
                    $parsed[] = $matches[$matchIndex] ?? null;
                }
            }
        } else {
            $parsed = $text;
        }

        return $parsed;
    }

    /**
     * Parse text or attribute
     *
     * @param array $guid
     * @return string[]|null
     */
    protected function stdParse(array $guid): ?array
    {
        $selector = $guid[static::_GUID_KEY_SELECTOR] ?? null;
        $attribute = $guid[static::_GUID_KEY_ATTRIBUTE] ?? null;

        if (is_null($selector)) {
            return null;
        }

        if (is_null($attribute)) {
            return $this->parseText($selector);
        } else {
            return $this->parseAttribute($selector, $attribute);
        }
    }

    public function parseRawResult()
    {
        foreach ($this->parsingGuid as $guid) {
            $key = $guid[static::_GUID_KEY_KEY];
            $selector = $guid[static::_GUID_KEY_SELECTOR] ?? null;
            $callback = $guid[static::_GUID_KEY_CALLBACK] ?? null;

            if (is_null($selector) && is_null($callback)) {
                $this->rawResult[$key] = null;

                continue;
            }

            if (is_callable($callback)) {
                $this->rawResult[$key] = $callback($guid);

                continue;
            }

            if (! is_null($selector)) {
                $index = 0;
                foreach ($this->stdHandler($guid) as $value) {
                    $this->rawResult[$index][$key] = $value;
                    $index++;
                }

                continue;
            }
        }
    }
}
