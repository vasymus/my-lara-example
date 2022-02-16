<?php

namespace Domain\Users\Models\User;

use Database\Factories\UserFactory;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends BaseUser
{
    use HasFactory;

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("user", function (Builder $builder) {
            $builder->where(sprintf("%s.status", static::TABLE), "<", static::ADMIN_THRESHOLD);
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
