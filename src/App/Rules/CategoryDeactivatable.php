<?php

namespace App\Rules;

use Domain\Products\Actions\HasActiveProductsAction;
use Domain\Products\Models\Category;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class CategoryDeactivatable implements Rule, DataAwareRule
{
    /**
     * The data under validation.
     *
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected string $idField;

    /**
     * @var string|null
     */
    protected ?string $idValue;

    /**
     * @var bool
     */
    protected bool $categoryExists = false;

    /**
     * @var string
     */
    protected string $isActiveField;

    /**
     * @var \Domain\Products\Actions\HasActiveProductsAction
     */
    protected HasActiveProductsAction $hasActiveProductsAction;

    /**
     * @var string
     */
    protected string $message = '';

    /**
     * Create a new rule instance.
     *
     * @param string $idField
     * @param string $isActiveField
     *
     * @return void
     */
    public function __construct(string $idField = 'id', string $isActiveField = 'is_active')
    {
        $this->idField = $idField;
        $this->isActiveField = $isActiveField;
        $this->hasActiveProductsAction = resolve(HasActiveProductsAction::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value) {
            return true;
        }
        $this->idValue = Arr::get($this->data, str_replace($this->isActiveField, $this->idField, $attribute), null);

        if (! $this->idValue) {
            $this->message = ':attribute отсутствует id категории.';

            return false;
        }

        $this->categoryExists = Category::query()->where(Category::TABLE . ".id", $this->idValue)->exists();
        if (! $this->categoryExists) {
            $this->message = ":attribute категории с id: {$this->idValue} не существует.";

            return false;
        }

        $hasActiveProducts = $this->hasActiveProductsAction->execute($this->idValue);

        if ($hasActiveProducts) {
            $this->message = ":attribute категория с id {$this->idValue} не может быть деактивирована, пока у этой категории и или у её подкатегорий есть активные продукты.";

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
