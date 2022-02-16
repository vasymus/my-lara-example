<?php

namespace Domain\Common\Actions;

use Support\H;

abstract class BaseAction
{
    /**
     * @return static
     */
    public static function cached(): self
    {
        return H::runtimeCache(static::class, fn () => resolve(static::class));
    }
}
