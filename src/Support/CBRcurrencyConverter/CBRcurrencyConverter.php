<?php

namespace Support\CBRcurrencyConverter;

use Carbon\Carbon;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;
use NumberFormatter;
use SimpleXMLElement;

class CBRcurrencyConverter
{
    public const USD = "USD";
    public const EUR = "EUR";
    public const RUB = "RUB";

    private static $currencies = [self::USD, self::EUR, self::RUB];

    /**
     * @var string
     * */
    private static $format = "d/m/Y";

    /**
     * @var array
     * */
    private static $cacheRates = [];

    /**
     * @var string
     * */
    private static $baseUrl = "http://www.cbr.ru/scripts/XML_daily.asp";

    /**
     * @var string
     * */
    private static $dateParam = "date_req";

    public static function convertRub(string $currency, float $value, Carbon $date = null): float
    {
        static::check($currency, $value, $date);

        if ($currency === static::RUB) {
            return $value;
        }

        $rate = static::getRate($currency, $date);

        return $rate * $value;
    }

    public static function getRate(string $currency, Carbon $date = null): float
    {
        if ($date === null) {
            $date = Carbon::now();
        }

        $key = $date->format(self::$format);

        //return Cache::remember() TODO think of caching

        if (isset(self::$cacheRates[$key][$currency])) {
            return self::$cacheRates[$key][$currency];
        }

        $xml = static::fetchXml($date);

        return self::$cacheRates[$key][$currency] = static::parseRate($xml, $currency);
    }

    public static function fetchXml(Carbon $date): string
    {
        /** @var Builder $builder */
        $builder = Curl::to(self::$baseUrl . "?" . self::$dateParam . "=" . $date->format(self::$format));

        $result = $builder->get();

        if (empty($result)) {
            throw new CBRcurrencyConverterException();
        }

        return $result;
    }

    public static function parseRate(string $xml, string $currency): float
    {
        $valCurs = new SimpleXMLElement($xml);

        $rate = null;

        foreach ($valCurs as $valute) {
            if ("{$valute->CharCode}" === $currency) {
                $rate = "{$valute->Value}";
            }
        }
        if ($rate === null) {
            throw new CBRcurrencyConverterException("Failed to parse rate for '$currency'");
        }

        return (new NumberFormatter("ru_RU", NumberFormatter::DECIMAL))->parse($rate);
    }

    public static function check(string $currency, float $value, Carbon $date = null): bool
    {
        if (! in_array($currency, self::$currencies)) {
            throw new \LogicException("Only " . implode(", ", self::$currencies) . " are allowed.");
        }

        //if ($value < 0) throw new \LogicException("Value should positive or '0'");

        if (
            $date !== null &&
            $date->copy()->startOfDay()->gt(Carbon::now()->startOfDay())
        ) {
            throw new \LogicException("Date shouldn't be greater then today");
        }

        return true;
    }
}
