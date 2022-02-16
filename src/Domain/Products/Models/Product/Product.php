<?php

namespace Domain\Products\Models\Product;

use Database\Factories\ProductFactory;
use Domain\Common\Models\BaseModel;
use Domain\Common\Models\Currency;
use Domain\Common\Models\HasDeletedItemSlug;
use Domain\Products\Collections\ProductCollection;
use Domain\Products\DTOs\Web\CharCategoryDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharCategory;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $slug
 * @property int|null $parent_id
 * @property bool $is_with_variations
 * @property int|null $category_id
 * @property int|null $ordering
 * @property bool $is_active
 * @property int|null $brand_id
 * @property string|null $coefficient
 * @property string|null $coefficient_description
 * @property bool $coefficient_description_show
 * @property string|null $coefficient_variation_description
 * @property string|null $price_name
 * @property string|null $admin_comment
 * @property float|null $price_purchase
 * @property int|null $price_purchase_currency_id
 * @property string|null $unit
 * @property float|null $price_retail
 * @property int|null $price_retail_currency_id
 * @property int $availability_status_id
 * @property string|null $preview
 * @property string|null $description
 *
 * @property string $accessory_name
 * @property string $similar_name
 * @property string $related_name
 * @property string $work_name
 * @property string $instruments_name
 *
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property array $meta
 *
 * @property bool $is_public_viewable
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property \Domain\Orders\Models\Pivots\OrderProduct|null $order_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::cart()
 * @property \Domain\Users\Models\Pivots\ProductUserCart|null $cart_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::viewed()
 * @property \Domain\Users\Models\Pivots\ProductUserViewed|null $viewed_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::aside()
 * @property \Domain\Users\Models\Pivots\ProductUserAside|null $aside_product
 *
 * @method static \Domain\Products\QueryBuilders\ProductQueryBuilder query()
 **/
class Product extends BaseModel implements HasMedia
{
    use ProductRelations;
    use SoftDeletes;
    use InteractsWithMedia;
    use ProductAcM;
    use HasDeletedItemSlug;
    use HasFactory;

    public const DEFAULT_IS_ACTIVE = false;
    public const DEFAULT_IS_WITH_VARIATIONS = false;
    public const DEFAULT_COEFFICIENT_DESCRIPTION_SHOW = false;
    public const DEFAULT_PRICE_NAME = 'Цена';
    public const DEFAULT_AVAILABILITY_STATUS_ID = AvailabilityStatus::ID_NOT_AVAILABLE;
    public const DEFAULT_ACCESSORY_NAME = 'Аксессуары';
    public const DEFAULT_SIMILAR_NAME = 'Похожие';
    public const DEFAULT_RELATED_NAME = 'Сопряженные';
    public const DEFAULT_WORK_NAME = 'Работы';
    public const DEFAULT_INSTRUMENTS_NAME = 'Инструменты';
    public const DEFAULT_CURRENCY_ID = Currency::ID_RUB;
    public const DEFAULT_ORDERING = 500;

    public const TABLE = "products";

    public const MAX_CHARACTERISTIC_RATE = 5;

    public const MC_MAIN_IMAGE = "main";
    public const MC_ADDITIONAL_IMAGES = "images";
    public const MC_FILES = "files";

    public const MCONV_XS_THUMB = "xs-thumb"; // 40x40
    public const MCONV_XS_THUMB_SIZE = 40;
    public const MCONV_SM_THUMB = "sm-thumb"; // 50x50
    public const MCONV_SM_THUMB_SIZE = 50;
    public const MCONV_MD_THUMB = "md-thumb"; // 120x120
    public const MCONV_MD_THUMB_SIZE = 120;
    public const MCONV_LG_THUMB = "lg-thumb"; // 220x220
    public const MCONV_LG_THUMB_SIZE = 220;
    public const MCONV_FILL_BG = "ffffff";

    public const DELIVERY_PRODUCT_UUID = 'd097bbbb-1a6f-44e2-acb8-0f5fdf672c37';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'is_active' => self::DEFAULT_IS_ACTIVE,
        'is_with_variations' => self::DEFAULT_IS_WITH_VARIATIONS,
        'coefficient_description_show' => self::DEFAULT_COEFFICIENT_DESCRIPTION_SHOW,
        'price_name' => self::DEFAULT_PRICE_NAME,
        'availability_status_id' => self::DEFAULT_AVAILABILITY_STATUS_ID,
        'accessory_name' => self::DEFAULT_ACCESSORY_NAME,
        'similar_name' => self::DEFAULT_SIMILAR_NAME,
        'related_name' => self::DEFAULT_RELATED_NAME,
        'work_name' => self::DEFAULT_WORK_NAME,
        'instruments_name' => self::DEFAULT_INSTRUMENTS_NAME,
        'ordering' => self::DEFAULT_ORDERING,
        'is_public_viewable' => true,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "boolean",
        "is_with_variations" => "boolean",
        "coefficient_description_show" => "boolean",
        'meta' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
    ];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        static::booting();

        $cb = function (self $product) {
            if (! $product->uuid) {
                $product->uuid = (string) Str::uuid();
            }
        };

        static::saving($cb);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    /**
     * @inheritDoc
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! $this->uuid) {
            $this->uuid = (string) Str::uuid();
        }
    }

    public static function rbProductSlug($value, Route $route)
    {
        /** @var Category $category */
        $category = $route->category_slug; // @phpstan-ignore-line
        /** @var \Domain\Products\Models\Category|null $subcategory1 */
        $subcategory1 = $route->subcategory1_slug; // @phpstan-ignore-line
        /** @var \Domain\Products\Models\Category|null $subcategory2 */
        $subcategory2 = $route->subcategory2_slug; // @phpstan-ignore-line
        /** @var Category|null $subcategory3 */
        $subcategory3 = $route->subcategory3_slug; // @phpstan-ignore-line

        return static::query()
            ->where(static::TABLE . ".slug", $value)
            ->where(function (Builder $builder) use ($category, $subcategory1, $subcategory2, $subcategory3) {
                return $builder
                        ->orWhere(static::TABLE . ".category_id", $category->id)
                        ->when($subcategory3->id ?? null, function (Builder $b, $sub3Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub3Id);
                        })
                        ->when($subcategory2->id ?? null, function (Builder $b, $sub2Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub2Id);
                        })
                        ->when($subcategory1->id ?? null, function (Builder $b, $sub1Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub1Id);
                        })
                ;
            })
            ->firstOrFail()
        ;
    }

    public static function rbAdminProduct($value)
    {
        return static::query()->select(["*"])->notVariations()->findOrFail($value);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;

        $this->addMediaCollection(static::MC_ADDITIONAL_IMAGES);

        $this->addMediaCollection(static::MC_FILES);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(static::MCONV_XS_THUMB) // @phpstan-ignore-line
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_XS_THUMB_SIZE,
                static::MCONV_XS_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_SM_THUMB) // @phpstan-ignore-line
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_SM_THUMB_SIZE,
                static::MCONV_SM_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_MD_THUMB) // @phpstan-ignore-line
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_MD_THUMB_SIZE,
                static::MCONV_MD_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_LG_THUMB) // @phpstan-ignore-line
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_LG_THUMB_SIZE,
                static::MCONV_LG_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array<int, \Domain\Products\Models\Product\Product> $models
     *
     * @return \Domain\Products\Collections\ProductCollection<\Domain\Products\Models\Product\Product>
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Domain\Products\QueryBuilders\ProductQueryBuilder<\Domain\Products\Models\Product\Product>
     */
    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    /**
     * @return \Domain\Products\DTOs\Web\CharCategoryDTO[]
     */
    public function characteristics(): array
    {
        return Cache::store('array')
            ->rememberForever(
                sprintf('%s-characteristics-%s', static::class, $this->id),
                fn () => $this->charCategories->map(fn (CharCategory $charCategory) => CharCategoryDTO::fromModel($charCategory))->all()
            );
    }

    public function characteristicsIsEmpty(): bool
    {
        $characteristics = $this->characteristics();

        foreach ($characteristics as $charCategory) {
            foreach ($charCategory->chars as $char) {
                if (! $char->is_empty) {
                    return false;
                }
            }
        }

        return true;
    }
}
