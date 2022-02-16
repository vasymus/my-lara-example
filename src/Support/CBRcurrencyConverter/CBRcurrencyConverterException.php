<?php

namespace Support\CBRcurrencyConverter;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CBRcurrencyConverterException extends HttpException
{
    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     *
     * @return void
     */
    public function __construct(string $message = null)
    {
        parent::__construct(424, $message ?: "Failed to fetch xml to convert currencies.");
    }
}
