<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferGallery extends BaseTransfer
{
    public function transfer()
    {
        $list = require(storage_path("app/seeds/photos/raw-list.php"));
        $seeds = [];

        foreach ($list as $item) {
            $id = $this->getIncrementId();
            $_oldId = (int)$item["ID"];

            $mainImageSrc = $item["PICTURE"]["SRC"];
            $mainImage = $this->fetchAndStoreMedia($id, $mainImageSrc, $item["PICTURE"]["ORIGINAL_NAME"], $item["PICTURE"]["ID"]);
            if (! $mainImage) {
                dump("Failed to store $mainImageSrc");
            }

            $seed = [
                "id" => $id,
                "name" => $item["NAME"],
                "slug" => $item["CODE"],
                "description" => $item["DESCRIPTION"],
                "ordering" => (int)$item["SORT"],
                "mainImage" => $mainImage,
                "_old_id" => $_oldId,
                "subPhotos" => [],
            ];

            $subPhotos = require(storage_path("app/seeds/photos/gallery-items/$_oldId.php"));
            foreach ($subPhotos as $subPhoto) {
                $subId = $this->getIncrementId();

                $subMaingImageSrc = $subPhoto["PREVIEW_PICTURE"]["SRC"];
                $subMainImage = $this->fetchAndStoreMedia(
                    $subId,
                    $subMaingImageSrc,
                    null,
                    $subPhoto["PREVIEW_PICTURE"]["ID"]
                );
                if (! $subMainImage) {
                    dump("Failed to store $subMaingImageSrc");
                }

                $seed["subPhotos"][] = [
                    "id" => $subId,
                    "name" => $subPhoto["NAME"],
                    "slug" => null,
                    "description" => $subPhoto["PREVIEW_TEXT"],
                    "ordering" => (int)$subPhoto["SORT"],
                    "mainImage" => $subMainImage,
                    "_old_id" => $subPhoto["ID"],
                ];
            }

            $seeds[] = $seed;
        }

        Storage::put("seeds/photos/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    public function fetchAndStoreRaw(int $zeroBasedIndexStart = null)
    {
        $detailPageUrls = require(storage_path("app/seeds/photos/raw-list.php"));

        foreach ($detailPageUrls as $zeroBasedIndex => $item) {
            if ($zeroBasedIndex < $zeroBasedIndexStart) {
                continue;
            }

            $location = $item["SECTION_PAGE_URL"];
            $fileName = "$item[ID].php";

            $isSuccess = $this->fetchAndStoreRawItem($location, $fileName);

            if (! $isSuccess) {
                dump("Failed to fetch and store / parse $location | File name: $fileName");
            }
        }
    }

    public function fetchAndStoreRawItem(string $location, string $fileName): bool
    {
        if (Storage::exists("seeds/photos/gallery-items/$fileName")) {
            dump("File $fileName exists");

            return true;
        }

        $html = $this->fetchHtml($location);
        if (! $html) {
            return false;
        }

        $startFlag = "<!-----START----->";
        $endFlag = "<!-----END----->";

        $afterStartArr = explode($startFlag, $html);

        if (count($afterStartArr) < 2) {
            return false;
        }

        $afterStart = $afterStartArr[1];
        $arrayString = explode($endFlag, $afterStart)[0];

        $phpString = "<?php\n\nreturn $arrayString;";

        return Storage::put("seeds/photos/gallery-items/$fileName", $phpString);
    }

    public function fetchAndStoreMedia(int $attachToId, string $src = null, string $originalName = null, $oldImageId = null): ?array
    {
        if (! $src) {
            return null;
        }

        $storeFolder = $this->getStdStorageFolder("photos");

        $imageOriginalName = $originalName ?? basename($src);
        $extenstion = pathinfo($src)["extension"] ?? null;
        $newName = $extenstion ? "$oldImageId.$extenstion" : "$oldImageId";
        $storagePath = "$storeFolder/$attachToId/$newName";

        $storedFile = $this->fetchAndStoreFileToPath($src, $storagePath);

        if (! $storedFile) {
            return null;
        }

        return [
            "_old_id" => $oldImageId,
            "name" => $imageOriginalName,
            "src" => $storedFile,
            "attachTo_id" => $attachToId,
        ];
    }
}
