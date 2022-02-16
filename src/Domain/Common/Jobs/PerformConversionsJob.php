<?php

namespace Domain\Common\Jobs;

use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob as BasePerformConversionsJob;

class PerformConversionsJob extends BasePerformConversionsJob
{
    /**
     * The number of seconds before the job should be made available.
     *
     * @var \DateTimeInterface|\DateInterval|int|null
     */
    public $delay = 5;
}
