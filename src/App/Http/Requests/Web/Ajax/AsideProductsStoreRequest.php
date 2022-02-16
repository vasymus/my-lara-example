<?php

namespace App\Http\Requests\Web\Ajax;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AsideProductsStoreRequest extends FormRequest
{
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
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $existsIds = Product::query()->notVariations()->active()->pluck("id")->toArray();
            if (! in_array($this->id, $existsIds)) {
                $validator->errors()->add("id", "Id `{$this->id}` of product should exist, be active and not be a variation.");
            }
        });
    }
}
