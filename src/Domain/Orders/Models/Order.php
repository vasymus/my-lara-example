<?php

namespace Domain\Orders\Models;

use App\Constants;
use Database\Factories\OrderFactory;
use Domain\Common\Models\BaseModel;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Products\Collections\ProductCollection;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Support\H;

/**
 * @property int $id
 * @property int $order_status_id
 * @property int $user_id
 * @property int|null $admin_id
 * @property int $importance_id
 * @property int $customer_bill_status_id
 * @property string|null $customer_bill_description
 * @property int $provider_bill_status_id
 * @property string|null $provider_bill_description
 * @property string|null $comment_user
 * @property string|null $comment_admin
 * @property string|null $ps_status
 * @property string|null $ps_description
 * @property float|null $ps_amount
 * @property \Carbon\Carbon|null $ps_date
 * @property int|null $payment_method_id
 * @property string|null $payment_method_description
 * @property array|null $request
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property bool $cancelled
 * @property string|null $cancelled_description
 * @property \Illuminate\Support\Carbon|null $cancelled_date
 * @property int|null $busy_by_id
 * @property \Carbon\Carbon|null $busy_at
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property ProductCollection|Product[] $products
 *
 * @see \Domain\Orders\Models\Order::user()
 * @property \Domain\Users\Models\BaseUser\BaseUser $user
 *
 * @see \Domain\Orders\Models\Order::admin()
 * @property \Domain\Users\Models\Admin|null $admin
 *
 * @see \Domain\Orders\Models\Order::status()
 * @property \Domain\Orders\Models\OrderStatus $status
 *
 * @see \Domain\Orders\Models\Order::payment()
 * @property \Domain\Orders\Models\PaymentMethod $payment
 *
 * @see \Domain\Orders\Models\Order::customerBillStatus()
 * @property \Domain\Orders\Models\BillStatus $customerBillStatus
 *
 * @see \Domain\Orders\Models\Order::providerBillStatus()
 * @property \Domain\Orders\Models\BillStatus $providerBillStatus
 *
 * @see \Domain\Orders\Models\Order::events()
 * @property \Domain\Orders\Models\OrderEvent[]|\Illuminate\Database\Eloquent\Collection $events
 *
 * @see \Domain\Orders\Models\Order::getOrderPriceRetailRubAttribute()
 * @property-read float $order_price_retail_rub
 *
 * @see \Domain\Orders\Models\Order::getOrderPriceRetailRubFormattedAttribute()
 * @property-read string $order_price_retail_rub_formatted
 *
 * @see \Domain\Orders\Models\Order::getOrderProductsCountAttribute()
 * @property-read int $order_products_count
 *
 * @see \Domain\Orders\Models\Order::getStatusNameForUserAttribute()
 * @property-read string $status_name_for_user
 *
 * @see \Domain\Orders\Models\Order::getUserNameAttribute()
 * @property-read string $user_name
 *
 * @see \Domain\Orders\Models\Order::getUserEmailAttribute()
 * @property-read string $user_email
 *
 * @see \Domain\Orders\Models\Order::getUserPhoneAttribute()
 * @property-read string $user_phone
 *
 * @see \Domain\Orders\Models\Order::getIsIndividualAttribute()
 * @property-read bool $is_individual
 *
 * @see \Domain\Orders\Models\Order::getIsBusinessAttribute()
 * @property-read bool $is_business
 *
 * @see \Domain\Orders\Models\Order::getPaymentTypeLegalEntityNameAttribute()
 * @property-read string $payment_type_legal_entity_name
 *
 * @see \Domain\Orders\Models\Order::getInitialAttachmentsAttribute()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $initial_attachments
 *
 * @see \Domain\Orders\Models\Order::getPaymentMethodAttachmentsAttribute()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $payment_method_attachments
 *
 * @see \Domain\Orders\Models\Order::getCustomerInvoicesAttribute()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $customer_invoices
 *
 * @see \Domain\Orders\Models\Order::getSupplierInvoicesAttribute()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $supplier_invoices
 *
 * @see \Domain\Orders\Models\Order::getDateFormattedAttribute()
 * @property-read string|null $date_formatted
 *
 * @see \Domain\Orders\Models\Order::getIsBusyByOtherAdminAttribute()
 * @property-read bool $is_busy_by_other_admin
 *
 * @see \Domain\Orders\Models\Order::importance()
 * @property \Domain\Orders\Models\OrderImportance|null $importance
 *
 * @see \Domain\Orders\Models\Order::busyBy()
 * @property \Domain\Users\Models\BaseUser\BaseUser|null $busyBy
 * */
class Order extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const TABLE = "orders";

    public const MC_INITIAL_ATTACHMENT = "initial-attachment";
    public const MC_PAYMENT_METHOD_ATTACHMENT = "payment-method-attachment";
    public const MC_CUSTOMER_INVOICES = 'customer-invoices';
    public const MC_SUPPLIER_INVOICES = 'supplier-invoices';

    public const DEFAULT_CANCELLED = false;
    public const DEFAULT_ORDER_STATUS_ID = OrderStatus::DEFAULT_ID;
    public const DEFAULT_ORDER_IMPORTANCE = OrderImportance::DEFAULT_ID;
    public const DEFAULT_CUSTOMER_BILL_STATUS_ID = BillStatus::ID_NOT_BILLED;
    public const DEFAULT_PROVIDER_BILL_STATUS_ID = BillStatus::ID_NOT_BILLED;

    public const BUSY_SECONDS_THRESHOLD = 60;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'request' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'cancelled' => 'boolean',
        'cancelled_date' => 'datetime:Y-m-d H:i:s',
        'ps_date' => 'datetime',
        'busy_at' => 'datetime',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'order_status_id' => self::DEFAULT_ORDER_STATUS_ID,
        'cancelled' => self::DEFAULT_CANCELLED,
        'importance_id' => self::DEFAULT_ORDER_IMPORTANCE,
        'customer_bill_status_id' => self::DEFAULT_CUSTOMER_BILL_STATUS_ID,
        'provider_bill_status_id' => self::DEFAULT_PROVIDER_BILL_STATUS_ID,
    ];

    public static function rbAdminOrder($value)
    {
        return static::query()->select(["*"])->findOrFail($value);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, OrderProduct::TABLE, "order_id", "product_id")
            ->using(OrderProduct::class)
            ->as('order_product')
            ->withPivot([
                "count",
                'ordering',
                "price_purchase",
                "price_purchase_currency_id",
                "price_retail",
                "price_retail_currency_id",
                "name",
                'unit',
                'price_retail_rub',
                'price_retail_rub_origin',
                'price_retail_rub_was_updated',
            ])
        ;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, "user_id", "id");
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, "admin_id", "id");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, "order_status_id", "id");
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function importance(): BelongsTo
    {
        return $this->belongsTo(OrderImportance::class, 'importance_id', 'id');
    }

    public function customerBillStatus(): BelongsTo
    {
        return $this->belongsTo(BillStatus::class, 'customer_bill_status_id', 'id');
    }

    public function providerBillStatus(): BelongsTo
    {
        return $this->belongsTo(BillStatus::class, 'provider_bill_status_id', 'id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(OrderEvent::class, 'order_id', 'id')->orderBy(sprintf('%s.id', OrderEvent::TABLE), 'desc');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_INITIAL_ATTACHMENT)->useDisk(Constants::MEDIA_DISK_PRIVATE);

        $this->addMediaCollection(static::MC_PAYMENT_METHOD_ATTACHMENT)->useDisk(Constants::MEDIA_DISK_PRIVATE);

        $this->addMediaCollection(static::MC_CUSTOMER_INVOICES)->useDisk(Constants::MEDIA_DISK_PRIVATE);

        $this->addMediaCollection(static::MC_SUPPLIER_INVOICES)->useDisk(Constants::MEDIA_DISK_PRIVATE);
    }

    public function getOrderPriceRetailRubAttribute(): float
    {
        return $this->products->orderProductsSumRetailPriceRub();
    }

    public function getOrderPriceRetailRubFormattedAttribute(): string
    {
        return $this->products->orderProductsSumRetailPriceRubFormatted();
    }

    public function getOrderProductsCountAttribute(): int
    {
        return $this->products->orderProductsCount();
    }

    public function getStatusNameForUserAttribute(): string
    {
        switch (true) {
            case in_array($this->order_status_id, OrderStatus::IDS_OPEN): {
                return "Открыт";
            }
            case in_array($this->order_status_id, OrderStatus::IDS_PAYED): {
                return "Оплачен";
            }
            default: {
                return "Закрыт";
            }
        }
    }

    public function getUserNameAttribute(): string
    {
        return ! empty($this->user->name)
                ? $this->user->name
                : (
                    $this->request["name"] ?? ""
                )
        ;
    }

    public function getUserEmailAttribute(): string
    {
        return ! empty($this->user->email)
                ? $this->user->email
                : (
                    $this->request["email"] ?? ""
                )
        ;
    }

    public function getUserPhoneAttribute(): string
    {
        return ! empty($this->user->phone)
            ? $this->user->phone
            : (
                $this->request["phone"] ?? ""
            )
            ;
    }

    public function getIsIndividualAttribute(): bool
    {
        return in_array($this->payment_method_id, [PaymentMethod::ID_BANK_CARD, PaymentMethod::ID_CASH]);
    }

    public function getIsBusinessAttribute(): bool
    {
        return $this->payment_method_id === PaymentMethod::ID_CASHLESS_FROM_ACCOUNT;
    }

    public function getPaymentTypeLegalEntityNameAttribute(): string
    {
        return $this->is_individual
                ? "Физическое лицо"
                : (
                    $this->is_business
                        ? "Юридическое лицо"
                        : ""
                );
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[]
     * */
    public function getInitialAttachmentsAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_INITIAL_ATTACHMENT);
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[]
     * */
    public function getPaymentMethodAttachmentsAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_PAYMENT_METHOD_ATTACHMENT);
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[]
     * */
    public function getCustomerInvoicesAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_CUSTOMER_INVOICES);
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[]
     * */
    public function getSupplierInvoicesAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_SUPPLIER_INVOICES);
    }

    /**
     * @return string|null
     */
    public function getDateFormattedAttribute(): ?string
    {
        return $this->created_at instanceof Carbon
            ? $this->created_at->format('d.m.y H:i:s')
            : null;
    }

    /**
     * @return bool
     */
    public function getIsBusyByOtherAdminAttribute(): bool
    {
        if (! $this->busy_by_id || ! $this->busy_at) {
            return false;
        }

        return (string)$this->busy_by_id !== (string)(H::admin()->id) && $this->busy_at->diffInSeconds(now()) < static::BUSY_SECONDS_THRESHOLD;
    }

    public function busyBy(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, "busy_by_id", "id");
    }
}
