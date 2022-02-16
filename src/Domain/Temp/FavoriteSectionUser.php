<?php

namespace Domain\Temp;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $users
 * @property int $section_id
 */
class FavoriteSectionUser extends Pivot
{
    public const TABLE = 'favorite_section_user';

    protected $table = self::TABLE;
}
