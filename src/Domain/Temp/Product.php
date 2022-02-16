<?php

namespace Domain\Temp;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Product extends Model
{
    protected $table = 'products';

    public function sections()
    {
        return $this->hasMany(Section::class, 'product_id', 'id')->parent();
    }
}
