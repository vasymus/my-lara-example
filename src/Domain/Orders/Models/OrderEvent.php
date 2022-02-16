<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;
use Domain\Orders\Enums\OrderEventType;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @property int|null $user_id
 * @property \Domain\Orders\Enums\OrderEventType $type DB column is {@link int} @see {@link \Domain\Orders\Models\OrderEvent::getTypeAttribute()} {@link \Domain\Orders\Models\OrderEvent::setTypeAttribute()}
 * @property array $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 *
 * @see \Domain\Orders\Models\OrderEvent::order()
 * @property \Domain\Orders\Models\Order $order
 *
 * @see \Domain\Orders\Models\OrderEvent::user()
 * @property \Domain\Users\Models\BaseUser\BaseUser $user
 */
class OrderEvent extends BaseModel
{
    public const TABLE = 'order_events';

    public const UPDATED_AT = null;

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
        'payload' => 'array',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'payload' => '[]',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BaseUser::class, 'user_id', 'id');
    }

    /**
     * @return \Domain\Orders\Enums\OrderEventType
     */
    public function getTypeAttribute(): OrderEventType
    {
        return OrderEventType::from($this->attributes['type']);
    }

    /**
     * @param \Domain\Orders\Enums\OrderEventType $orderEventType
     *
     * @return void
     */
    public function setTypeAttribute(OrderEventType $orderEventType)
    {
        $this->attributes['type'] = $orderEventType->value;
    }
}
