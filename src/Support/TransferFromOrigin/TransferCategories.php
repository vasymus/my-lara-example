<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferCategories extends BaseTransfer
{
    public function transfer()
    {
        $raw = require(storage_path("app/seeds/categories/raw.php"));

        $result = [];

        foreach ($raw as $rawItem) {
            $oldParentId = $rawItem["IBLOCK_SECTION_ID"];
            $newParentId = null;
            if (! empty($oldParentId)) {
                $find = collect($result)->first(function (array $item) use ($oldParentId) {
                    return (int)$item["_old_id"] === (int)$oldParentId;
                });
                if (! $find) {
                    throw new \RuntimeException("Parent id not found.");
                }
                $newParentId = $find["id"];
            }

            $result[] = [
                "id" => $this->getIncrementId(),
                "name" => $rawItem["NAME"],
                "slug" => $rawItem["CODE"],
                "description" => $rawItem["DESCRIPTION"],
                "is_active" => true,
                "ordering" => (int)$rawItem["SORT"],
                "parent_id" => $newParentId,
                "_old_id" => (int)$rawItem["ID"],
                "_old_parent_id" => (int)$oldParentId,
                "seo_title" => $rawItem["IPROPERTY_VALUES"]["SECTION_META_TITLE"] ?? null,
                "seo_keywords" => $rawItem["IPROPERTY_VALUES"]["SECTION_META_KEYWORDS"] ?? null,
                "seo_content" => $rawItem["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"] ?? null,
            ];
        }

        Storage::put("seeds/categories/seeds.json", json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}
