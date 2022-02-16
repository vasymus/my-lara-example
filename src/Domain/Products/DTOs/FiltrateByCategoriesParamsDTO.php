<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class FiltrateByCategoriesParamsDTO extends DataTransferObject
{
    public ?Category $category;

    public ?Category $subcategory1;

    public ?Category $subcategory2;

    public ?Category $subcategory3;
}
