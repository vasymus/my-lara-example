<?php

namespace App\Http\Requests\Web;

use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

/**
 * @property-read string|null $name
 * @property-read string|null $email
 * @property-read string|null $phone
 * @property-read string|null $comment
 * @property-read \Illuminate\Http\UploadedFile[]|null $attachment
 * */
class CartCheckoutRequest extends FormRequest
{
    protected const MAX_FILE_SIZE_MB = 1;

    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser|null
     * */
    protected $emailUser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        return
//                 $this->getEmailUser() === null
//                 || !$this->getEmailUser()->is_admin
//                 || ($this->getEmailUser()->is_admin && !$this->isAuthUserEqualsEmailUser())
//            ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "string|nullable|max:199",
            "email" => "string|nullable|email|max:199",
            "phone" => "alpha_num|nullable|max:199",
            "comment" => "string|nullable|max:199",
            "attachment" => "array|nullable",
            "attachment.*" => sprintf('max:%s', 1024 * self::MAX_FILE_SIZE_MB), // TODO validations via mymetypes предполагается, что что-то типа файла с реквизитами (ексель, пдф, фото реквизитов) !!! может несколько файлов // ВОЗМОЖНО ПРОДУМАТЬ КАКОЙ-ТО общий размер файлов с какого-то ip адреса
        ];
    }

    // todo customize messages

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $this->validateCartNotEmpty();
            if ($this->getAuthUser()->is_anonymous2) {
                $this->validateAnonymous();
            }
        });
    }

    protected function validateCartNotEmpty()
    {
        if ($this->getAuthUser()->cart_not_trashed->isEmpty()) {
            $this->getValidatorInstance()->errors()->add("cart", "У вас пустая корзина.");
        }
    }

    protected function validateAnonymous()
    {
        if (empty($this->email)) {
            $this->getValidatorInstance()->errors()->add("email", "E-mail поле обязательно.");
        }
        if (empty($this->name)) {
            $this->getValidatorInstance()->errors()->add("name", "Имя обязательно.");
        }
        if (empty($this->phone)) {
            $this->getValidatorInstance()->errors()->add("phone", "Телефон обязателен.");
        }
    }

    protected function getAuthUser(): BaseUser
    {
        return H::userOrAdmin();
    }

    public function getEmailUser(): ?BaseUser
    {
        if ($this->emailUser !== null) {
            return $this->emailUser;
        }

        return $this->emailUser = BaseUser::query()->where("email", $this->email)->first();
    }

    public function isAuthUserEqualsEmailUser(): bool
    {
        $authUser = $this->getAuthUser();
        $emailUser = $this->getEmailUser();

        return $authUser->id === $emailUser->id;
    }
}
