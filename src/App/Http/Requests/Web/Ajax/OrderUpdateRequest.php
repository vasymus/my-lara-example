<?php

namespace App\Http\Requests\Web\Ajax;

use Domain\Orders\Models\Order;
use Domain\Orders\Models\PaymentMethod;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Support\H;

/**
 * @property-read int $order_id
 * @property-read int $payment_method_id
 * @property-read string|null $payment_method_description
 * @property-read \Illuminate\Http\UploadedFile[]|null $attachment
 * */
class OrderUpdateRequest extends FormRequest
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
            "order_id" => [
                "required",
                Rule::exists(Order::TABLE, "id")->where("user_id", $this->getAuthUser()->id),
            ],
            "payment_method_id" => "required|exists:" . PaymentMethod::class . ",id",
            "payment_method_description" => "string|nullable|max:1000",
            "attachment" => "array|nullable",
            "attachment.*" => "file|max:10000", // TODO validations via mymetypes предполагается, что что-то типа файла с реквизитами (ексель, пдф, фото реквизитов) !!! может несколько файлов // ВОЗМОЖНО ПРОДУМАТЬ КАКОЙ-ТО общий размер файлов с какого-то ip адреса
        ];
    }

    public function getAuthUser(): BaseUser
    {
        return Cache::store('array')->rememberForever(sprintf('%s-user', static::class), fn () => H::userOrAdmin());
    }
}
