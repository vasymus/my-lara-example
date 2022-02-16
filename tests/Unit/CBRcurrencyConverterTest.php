<?php

namespace Tests\Unit;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Support\CBRcurrencyConverter\CBRcurrencyConverter as CBRcurrencyConverterService;
use Tests\TestCase;

class CBRcurrencyConverterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFetchValidXml()
    {
        $xmlstr = CBRcurrencyConverterService::fetchXml(Carbon::now());

        libxml_use_internal_errors(true);

        $doc = simplexml_load_string($xmlstr);
        $xml = explode("\n", $xmlstr);

        $err = [];

        if (! $doc) {
            $errors = libxml_get_errors();

            foreach ($errors as $error) {
                $err[] = display_xml_error($error, $xml);
            }

            libxml_clear_errors();
        }

        $this->assertTrue(empty($err), "XML errors:\n" . implode("\n", $err));
    }

    public function testParseRate()
    {
        $xmlstr = Storage::get("currencies-rate.xml");

        $this->assertEquals(72.1719, CBRcurrencyConverterService::parseRate($xmlstr, "USD"));

        $this->assertEquals(81.4676, CBRcurrencyConverterService::parseRate($xmlstr, "EUR"));
    }

    public function testCheck()
    {
        $this->expectException(\LogicException::class);
        CBRcurrencyConverterService::check("UAH", 100.1, Carbon::now());

        $this->expectException(\LogicException::class);
        CBRcurrencyConverterService::check("USD", -100.1, Carbon::now());

        $this->expectException(\LogicException::class);
        CBRcurrencyConverterService::check("EUR", 11.1, Carbon::tomorrow());
    }
}
