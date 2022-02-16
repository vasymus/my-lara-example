<?php

namespace App\Http\Requests\Web\Ajax;

use Carbon\Carbon;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Support\H;

/**
 * @property int $id
 * @property int|null $count
 * @property string|null $updateCountMode
 * @property bool|null $delete
 * */
class CartProductsUpdateRequest extends FormRequest
{
    public const MODE_ADD = "add";
    public const MODE_NEW = "new";

    public const MODE_DEFAULT = self::MODE_ADD;

    /**
     * @var \Domain\Products\Models\Product\Product
     * */
    protected $product;

    /**
     * @return \Domain\Products\Models\Product\Product
     */
    protected function getProduct(): Product
    {
        return $this->product;
    }

    protected function getCount(): ?int
    {
        if ($this->count === null) {
            return null;
        }

        $mode = $this->input("updateCountMode", CartProductsUpdateRequest::MODE_ADD);
        if ($mode === CartProductsUpdateRequest::MODE_ADD) {
            return $this->getProductCurrentCount() + $this->count;
        } else {
            return $this->count;
        }
    }

    public function prepare(): array
    {
        $product = $this->getProduct();

        $prepared = [];

        $pivot = [];

        $count = $this->getCount();
        if ($count !== null) {
            $pivot["count"] = $count;
        }

        if ($this->delete !== null) {
            if ($this->delete) {
                $pivot["deleted_at"] = Carbon::now();
            } else {
                $pivot["deleted_at"] = null;
            }
        }

        if (! empty($pivot)) {
            $prepared[$product->id] = $pivot;
        }

        return $prepared;
    }

    protected function getProductCurrentCount(): int
    {
        return $this->product->cart_product->count ?? 1;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => "required|integer",
            "count" => "integer|min:1",
            "updateCountMode" => "in:" . static::MODE_ADD . "," . static::MODE_NEW,
            "delete" => "boolean",
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $user = H::userOrAdmin();

            $productQuery = $user->cart();

            $productQuery
                ->active()
                ->available()
                ->where(function (Builder $query) {
                    $query
                        ->orWhere(function (Builder $qu) {
                            /** @var \Domain\Products\QueryBuilders\ProductQueryBuilder $qu */
                            $qu->variations();
                        })
                        ->orWhere(function (Builder $qu) {
                            /** @var \Domain\Products\QueryBuilders\ProductQueryBuilder $qu */
                            $qu->doesntHaveVariations();
                        })
                    ;
                })
            ;
            $this->product = $productQuery->find($this->id);
            if (! $this->product) {
                $validator->errors()->add("id", "Id `{$this->id}` of product should exist, be active, be available and be a variation or product without variations.");
            }
        });
    }
}
