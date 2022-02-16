<?php

namespace Domain\Products\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class ViewedDTO extends DataTransferObject
{
    /**
     * @var string
     * */
    public $web_route;

    /**
     * @var string
     * */
    public $image_url;

    /**
     * @var string
     * */
    public $name;
}
