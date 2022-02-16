<?php

namespace App\Http\Requests\Web\Ajax;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;

class CartProductsDeleteRequest extends FormRequest
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
            "id" => "required|integer|exists:" . Product::class . ",id",
        ];
    }
}
