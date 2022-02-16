<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferManufacturers extends BaseTransfer
{
    public function transfer()
    {
        $raw = require(storage_path("app/seeds/manufacturers/raw.php"));

        $seeds = [];

        foreach ($raw as $rawItem) {
            $id = $this->getIncrementId();
            $preview = trim($rawItem["preview"]);
            $description = trim($rawItem["description"]);
            $image = ! empty($rawItem["imageSrc"]) ? $this->fetchAndStoreFile($rawItem["imageSrc"], $id, "manufacturers") : null;

            $seed = [
                "id" => $id,
                "name" => $rawItem["name"],
                "preview" => ! empty($preview) ? $preview : strip_tags($description),
                "description" => ! empty($description) ? $description : $preview,
                "image" => $image,
                "ordering" => (int) $rawItem["SORT"],
                "_old_id" => (int) $rawItem["id"],
            ];

            $seeds[] = $seed;
        }

        Storage::put("seeds/manufacturers/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }
}
