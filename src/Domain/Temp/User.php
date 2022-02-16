<?php

namespace Domain\Temp;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public function sections()
    {
        return $this->belongsToMany(Section::class, FavoriteSectionUser::TABLE);
    }
}
