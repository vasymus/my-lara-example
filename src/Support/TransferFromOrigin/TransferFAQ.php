<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferFAQ extends BaseTransfer
{
    public function transfer()
    {
        $raw = require(storage_path("app/seeds/faq/raw.php"));

        $result = [];

        foreach ($raw as $rawItem) {
            $result[] = [
                "id" => $this->getIncrementId(),
                "question" => $rawItem["question"],
                "answer" => $rawItem["answer"],
                "created_at" => $rawItem["created_at"],
                "is_active" => true,
                "user_email" => null,
                "user_name" => null,
            ];
        }

        Storage::put("seeds/faq/seeds.json", json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}
