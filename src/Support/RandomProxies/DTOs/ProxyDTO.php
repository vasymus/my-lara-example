<?php

namespace Support\RandomProxies\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class ProxyDTO extends DataTransferObject
{
    /**
     * @var string
     * */
    public $ip;

    /**
     * @var int
     * */
    public $port;

    /**
     * @var string
     * */
    public $countryCode;

    /**
     * @var string
     * */
    public $country;

    /**
     * @var string
     * */
    public $anonymity;

    /**
     * @var bool
     * */
    public $isGoogle = false;

    /**
     * @var bool
     * */
    public $isHttps = false;

    /**
     * @var \Carbon\Carbon|null
     * */
    public $lastChecked;
}
