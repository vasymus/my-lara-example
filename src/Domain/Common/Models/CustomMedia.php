<?php

namespace Domain\Common\Models;

use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\H;

/**
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @see \Domain\Common\Models\CustomMedia::getMimeTypeNameAttribute()
 * @property-read string $mime_type_name
 *
 * @see {@link \Domain\Common\Models\CustomMedia::getDeleteTimeAttribute()} {@link \Domain\Common\Models\CustomMedia::setDeleteTimeAttribute()}
 * @property \DateTimeInterface|null $delete_time
 */
class CustomMedia extends Media
{
    use CommonTraits;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = "mysql";

    public function getMimeTypeNameAttribute(): string
    {
        return H::getMimeTypeName($this->mime_type);
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeleteTimeAttribute(): ?DateTimeInterface
    {
        if (! $this->getCustomProperty('deleteTime')) {
            return null;
        }

        try {
            return Carbon::parse($this->getCustomProperty('deleteTime'));
        } catch (InvalidFormatException $ignored) {
            return null;
        }
    }

    /**
     * @param \DateTimeInterface $dateTime
     */
    public function setDeleteTimeAttribute(DateTimeInterface $dateTime)
    {
        $this->setCustomProperty('deleteTime', $dateTime);
    }
}
