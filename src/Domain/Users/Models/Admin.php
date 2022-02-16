<?php

namespace Domain\Users\Models;

use App\Constants;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends BaseUser implements HasMedia
{
    use InteractsWithMedia;

    public const ID_CENTRAL_ADMIN = 1;

    public const ID_HELEN_ADMIN = 2;

    public const ID_NASTYA_ADMIN = 3;

    public const MC_COMMON_MEDIA = "common-media"; // use as walkaround to many-to-one of spatie/medialibrary @see https://github.com/spatie/laravel-medialibrary/issues/1215#issuecomment-415555175

    public const MC_EXPORT_PRODUCTS = 'export-products';

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("admin", function (Builder $builder) {
            $builder->where(static::TABLE . ".status", ">=", static::ADMIN_THRESHOLD);
        });
    }

    public static function getCentralAdmin(): self
    {
        /** @var \Domain\Users\Models\Admin $admin */
        $admin = Admin::query()->findOrFail(Admin::ID_CENTRAL_ADMIN);

        return $admin;
    }

    public static function rbAdmin($value)
    {
        return static::query()->select(["*"])->findOrFail($value);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_COMMON_MEDIA);

        $this->addMediaCollection(static::MC_EXPORT_PRODUCTS)->useDisk(Constants::MEDIA_DISK_PRIVATE);
    }
}
