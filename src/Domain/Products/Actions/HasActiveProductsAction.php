<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class HasActiveProductsAction
{
    /**
     * @param string|int $id
     *
     * @return bool
     */
    public function execute($id): bool
    {
        $categoryT = Category::TABLE;
        $subcategory1Alias = "c2";
        $subcategory2Alias = "c3";
        $productT = Product::TABLE;
        $productAlias = "p1";

        return Category::query()
            ->select("$categoryT.id")
            ->leftJoin("$categoryT as $subcategory1Alias", function (JoinClause $query) use ($categoryT, $subcategory1Alias) {
                $query->on("$categoryT.id", "=", "$subcategory1Alias.parent_id")
                    ->whereNull("$subcategory1Alias.deleted_at");
            })
            ->leftJoin("$categoryT as $subcategory2Alias", function (JoinClause $query) use ($subcategory1Alias, $subcategory2Alias) {
                $query->on("$subcategory1Alias.id", "=", "$subcategory2Alias.parent_id")
                    ->whereNull("$subcategory2Alias.deleted_at");
            })
            ->join("$productT as $productAlias", function (JoinClause $query) use ($categoryT, $subcategory1Alias, $subcategory2Alias, $productAlias) {
                $query->whereRaw(
                    DB::raw("$productAlias.category_id in (`$categoryT`.`id`, `$subcategory1Alias`.`id`, `$subcategory2Alias`.`id`)")
                )
                    ->where("$productAlias.is_active", true)
                    ->whereNull("$productAlias.deleted_at");
            })
            ->where("$categoryT.id", $id)
            ->exists();
    }
}
