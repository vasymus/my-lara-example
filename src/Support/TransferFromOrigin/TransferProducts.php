<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class TransferProducts extends BaseTransfer
{
    /** @var Collection|null */
    protected $categories;

    /** @var Collection|null */
    protected $manufacturers;

    /** @var Collection|null */
    protected $productSeedsByOldId;

    public function transfer()
    {
        $this->categories = collect(json_decode(Storage::get("seeds/categories/seeds.json"), true));
        $this->manufacturers = collect(json_decode(Storage::get("seeds/manufacturers/seeds.json"), true));

        // handle general
        $this->transferGeneral();
        // handle properties
        $this->transferProperties();

        //dd("stop");

        // handle media
        $this->transferMedia();
        // handle offers and characteristics
        $this->transferOffersAndCharacteristics();
        // handle transfer product prices
        $this->transferPrices();
    }

    public function fetchAndStoreRaw(int $zeroBasedIndexStart = null)
    {
        $detailPageUrls = require(storage_path("app/seeds/products/links.php"));

        foreach ($detailPageUrls as $zeroBasedIndex => $location) {
            if ($zeroBasedIndex < $zeroBasedIndexStart) {
                continue;
            }

            $isSuccess = $this->fetchAndStoreRawItem($location);
            if (! $isSuccess) {
                dump("Failed to fetch and store / parse $location");
            }
        }
    }

    public function fetchAndStoreRawItem(string $location): bool
    {
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

        static $i = 1;

        $phpString = "<?php\n\nreturn $arrayString;";

        $name = "$i.php";
        $i++;

        return Storage::put("seeds/products/offers-and-chars/$name", $phpString);
    }

    public function transferGeneral()
    {
        $seeds = [];

        for ($i = 1; $i <= 11; $i++) {
            $raw = require(storage_path("app/seeds/products/raw-50-$i.php"));

            foreach ($raw as $rawItem) {
                if ($this->shouldIgnore($rawItem)) {
                    continue;
                }

                $this->checkRawItem($rawItem);

                $_old_category_id = (int)$rawItem["IBLOCK_SECTION_ID"];

                $id = $this->getIncrementId();
                $category = $this->getCategoryByOldId($_old_category_id);

                $seed = [
                    "id" => $id,
                    "name" => $rawItem["NAME"],
                    "slug" => $rawItem["CODE"],
                    "ordering" => (int)$rawItem["SORT"],
                    "preview" => $rawItem["PREVIEW_TEXT"],
                    "description" => $rawItem["DETAIL_TEXT"],
                    "category_id" => (int)$category["id"],
                    "created_at" => null,

                    "_old_id" => (int)$rawItem["ID"],
                    "_old_category_id" => $_old_category_id,
                ];
                $seeds[] = $seed;
            }
        }

        Storage::put("seeds/products/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));

        $this->productSeedsByOldId = collect(
            collect($seeds)->reduce(function (array $acc, array $item) {
                $acc[$item["_old_id"]] = $item;

                return $acc;
            }, [])
        );
    }

    public function transferProperties()
    {
        $productsSeeds = collect(json_decode(Storage::get("seeds/products/seeds.json"), true));

        for ($i = 1; $i <= 11; $i++) {
            $raw = require(storage_path("app/seeds/products/raw-50-$i.php"));

            foreach ($raw as $rawItem) {
                if ($this->shouldIgnore($rawItem)) {
                    continue;
                }

                $this->checkRawItem($rawItem);

                $_oldProductId = (int)$rawItem["ID"];

                $productKey = $productsSeeds->search(function (array $pr) use ($_oldProductId) {
                    return (int)$pr["_old_id"] === $_oldProductId;
                });
                if ($productKey === false) {
                    continue;
                }

                $product = $productsSeeds->get($productKey);
                $product = array_merge($product, $this->getSeedDataFromProperties($rawItem));
                $productsSeeds->put($productKey, $product);
            }
        }


        Storage::put("seeds/products/seeds.json", json_encode($productsSeeds, JSON_UNESCAPED_UNICODE));
    }

    public function transferMedia()
    {
        $raw = require(storage_path("app/seeds/products/raw-media.php"));
        $productsSeeds = collect(json_decode(Storage::get("seeds/products/seeds.json"), true));

        foreach ($raw as $rawItem) {
            $_oldProductId = (int)$rawItem["ID"];

            $productKey = $productsSeeds->search(function (array $pr) use ($_oldProductId) {
                return (int)$pr["_old_id"] === $_oldProductId;
            });
            if ($productKey === false) {
                continue;
            }

            $product = $productsSeeds->get($productKey);

            $newProductId = (int)$product["id"];

            $files = $rawItem["media"]["files"] ?? [];
            $images = $rawItem["media"]["images"] ?? [];
            $mainImage = $rawItem["media"]["mainImage"];

            $storeFolder = $this->getStdStorageFolder("products");
            $storeFolder = "$storeFolder/$newProductId";

            $loop = function (string $type, array $rawFile) use ($storeFolder, $newProductId, $_oldProductId): ?array {
                $src = $rawFile["SRC"];
                $originalName = $rawFile["ORIGINAL_NAME"] ?? basename($src);
                $extenstion = pathinfo($src)["extension"] ?? null;
                $_oldMediaId = (int)$rawFile["ID"];
                $newName = $extenstion ? "$_oldMediaId.$extenstion" : "$_oldMediaId";
                $storagePath = "$storeFolder/$type/$newName";

                //$storedFile = $this->fetchAndStoreFileToPath($src, $storagePath);

                //if (!$storedFile) return null;

                $storedFile = $storagePath; // TODO temp
                if (! Storage::exists($storedFile)) {
                    return null;
                }

                return [
                    "_old_id" => $_oldMediaId,
                    "name" => $originalName,
                    "src" => $storedFile,
                    "product_id" => $newProductId,
                    "_old_product_id" => $_oldProductId,
                ];
            };

            $media = [
                "mainImage" => null,
                "images" => [],
                "files" => [],
            ];
            if ($mainImage) {
                $media["mainImage"] = $loop("mainImage", $mainImage);
            }
            foreach ($images as $image) {
                $media["images"][] = $loop("images", $image);
            }
            foreach ($files as $file) {
                $media["files"][] = $loop("files", $file);
            }

            $product["media"] = $media;

            $productsSeeds->put($productKey, $product);
        }

        Storage::put("seeds/products/seeds.json", json_encode($productsSeeds, JSON_UNESCAPED_UNICODE));
    }

    public function transferOffersAndCharacteristics()
    {
        $productsSeeds = collect(json_decode(Storage::get("seeds/products/seeds.json"), true));
        $count = count(Storage::allFiles("seeds/products/offers-and-chars"));

        for ($i = 1; $i <= $count; $i++) {
            $itemData = require(storage_path("app/seeds/products/offers-and-chars/$i.php"));

            $_oldProductId = $itemData["ID"];
            $productKey = $productsSeeds->search(function (array $pr) use ($_oldProductId) {
                return (int)$pr["_old_id"] === $_oldProductId;
            });
            if ($productKey === false) {
                continue;
            }

            $product = $productsSeeds->get($productKey);
            $newProductId = $product["id"];

            $offers = $itemData["OFFERS"];
            $variations = [];
            $storeFolder = $this->getStdStorageFolder("products");
            $storeFolder = "$storeFolder/$newProductId";

            foreach ($offers as $offer) {
                $src = $offer["DETAIL_PICTURE"]["SRC"];
                if (! $src) {
                    continue;
                }

                $_originalImageName = $offer["DETAIL_PICTURE"]["ORIGINAL_NAME"] ?? basename($src);
                $extenstion = pathinfo($src)["extension"] ?? null;
                $_oldMediaId = (int)$offer["DETAIL_PICTURE"]["ID"];
                $newName = $extenstion ? "$_oldMediaId.$extenstion" : "$_oldMediaId";
                $storagePath = "$storeFolder/offers/$newName";

                $storedFile = $this->fetchAndStoreFileToPath($src, $storagePath);

                if (! $storedFile) {
                    return null;
                }

                $image = [
                    "_old_id" => $_oldMediaId,
                    "name" => $_originalImageName,
                    "src" => $storedFile,
                ];

                $variation = [
                    "name" => $offer['NAME'],
                    "price_retail" => $offer['ITEM_PRICES'][0]['PRICE'] ?? null,
                    "price_retail_currency_id" => ['ITEM_PRICES'][0]['CURRENCY'] ?? null, // @phpstan-ignore-line
                    "image" => $image,
                    "ordering" => $offer["SORT"],
                    "price_purchase" => $offer["PROPERTIES"]["purchase"]["VALUE"],
                    "price_purchase_currency_id" => $offer["PROPERTIES"]["purchase"]["DESCRIPTION"],
                    "is_active" => true,
                    "unit" => $offer["PROPERTIES"]["package"]["VALUE"],
                    "coefficient" => $offer["PROPERTIES"]["koef_price"]["VALUE"],
                    "is_in_stock" => $offer["PROPERTIES"]["order"]["VALUE"],
                    "preview" => $offer["PREVIEW_TEXT"],
                ];
                $variations[] = $variation;
            }

            $_ch = $itemData["characteristics"];
            $characteristics = [
                "ch_desc_trade_mark" => $_ch["trademark"]["VALUE"] ?? null,
                "ch_desc_country_name" => $_ch["country_of_origin"]["VALUE"] ?? null,
                "ch_desc_unit" => $_ch["unit"]["VALUE"] ?? null,
                "ch_desc_packing" => $_ch["packing"]["VALUE"] ?? null,
                "ch_desc_light_reflection" => $_ch["degree_of_gloss"]["VALUE"] ?? null,
                "ch_desc_material_consumption" => $_ch["consumption_material"]["VALUE"] ?? null,
                "ch_desc_apply_instrument" => $_ch["tool_coating"]["VALUE"] ?? null,
                "ch_desc_placement_temperature_moisture" => $_ch["temperature_humidity"]["VALUE"] ?? null,
                "ch_desc_drying_time" => $_ch["drying_time"]["VALUE"] ?? null,
                "ch_desc_special_characteristics" => $_ch["special_properties"]["VALUE"] ?? null,
                "ch_compatibility_wood_usual_rate" => $_ch["conventional_wood"]["VALUE"] ?? null,
                "ch_compatibility_wood_exotic_rate" => $_ch["exotic_woods"]["VALUE"] ?? null,
                "ch_compatibility_wood_cork_rate" => $_ch["cork"]["VALUE"] ?? null,
                "ch_suitability_parquet_piece_rate" => $_ch["parquet"]["VALUE"] ?? null,
                "ch_suitability_parquet_massive_board_rate" => $_ch["massive_board"]["VALUE"] ?? null,
                "ch_suitability_parquet_board_rate" => $_ch["parquet_board"]["VALUE"] ?? null,
                "ch_suitability_parquet_art_rate" => $_ch["art_parquet"]["VALUE"] ?? null,
                "ch_suitability_parquet_laminate_rate" => $_ch["laminate"]["VALUE"] ?? null,
                "ch_suitability_placement_living_rate" => $_ch["accommodation"]["VALUE"] ?? null,
                "ch_suitability_placement_office_rate" => $_ch["offices"]["VALUE"] ?? null,
                "ch_suitability_placement_restaurant_rate" => $_ch["restaurants"]["VALUE"] ?? null,
                "ch_suitability_placement_child_and_medical_rate" => $_ch["children_hospitals"]["VALUE"] ?? null,
                "ch_suitability_placement_gym_rate" => $_ch["gyms"]["VALUE"] ?? null,
                "ch_suitability_placement_industrial_zone_rate" => $_ch["Industrial_zones"]["VALUE"] ?? null,
                "ch_exploitation_abrasion_resistance_rate" => $_ch["isteraymost"]["VALUE"] ?? null,
                "ch_exploitation_surface_firmness_rate" => $_ch["surface_hardness"]["VALUE"] ?? null,
                "ch_exploitation_elasticity_rate" => $_ch["elasticity"]["VALUE"] ?? null,
                "ch_exploitation_sustain_uv_rays_rate" => $_ch["resistance_to_UV"]["VALUE"] ?? null,
                "ch_exploitation_sustain_chemicals_rate" => $_ch["resistance_chemic"]["VALUE"] ?? null,
                "ch_exploitation_after_apply_wood_color" => $_ch["change_color"]["VALUE"] ?? null,
                "ch_exploitation_env_friendliness" => $_ch["environmentally"]["VALUE"] ?? null,
                "ch_storage_term" => $_ch["shelf_life"]["VALUE"] ?? null,
                "ch_storage_conditions" => $_ch["storage_conditions"]["VALUE"] ?? null,
            ];

            $product["variations"] = $variations;
            $product["characteristics"] = $characteristics;
            $productsSeeds->put($productKey, $product);
        }

        Storage::put("seeds/products/seeds.json", json_encode($productsSeeds, JSON_UNESCAPED_UNICODE));
    }

    public function transferPrices()
    {
        $productsSeeds = collect(json_decode(Storage::get("seeds/products/seeds.json"), true));

        for ($i = 1; $i <= 11; $i++) {
            $raw = require(storage_path("app/seeds/products/raw-prices-50-$i.php"));

            foreach ($raw as $rawItem) {
                $_oldProductId = $rawItem["ID"];
                $productKey = $productsSeeds->search(function (array $pr) use ($_oldProductId) {
                    return (int)$pr["_old_id"] === $_oldProductId;
                });
                if ($productKey === false) {
                    continue;
                }

                $product = $productsSeeds->get($productKey);

                $product["price_retail"] = $rawItem["ITEM_PRICES"][0]["PRICE"] ?? null;
                $product["price_retail_currency_id"] = $rawItem["ITEM_PRICES"][0]["CURRENCY"] ?? null;
                $productsSeeds->put($productKey, $product);
            }
        }
        Storage::put("seeds/products/seeds.json", json_encode($productsSeeds, JSON_UNESCAPED_UNICODE));
    }

    public function shouldIgnore(array $rawItem): bool
    {
        $category = $this->categories->where("_old_id", $rawItem["IBLOCK_SECTION_ID"])->first();
        /*if (!$category) {
            dump("No category with id $rawItem[IBLOCK_SECTION_ID] found for product with id $rawItem[ID] '$rawItem[NAME]'.");
        }*/
        return ! $category || $rawItem['NAME'] === 'Доставка';
    }

    public function checkRawItem(array $rawItem): bool
    {
        $requiredFields = ['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID', 'SORT', 'PREVIEW_TEXT', 'DETAIL_TEXT'];

        foreach ($requiredFields as $field) {
            if (! isset($rawItem[$field])) {
                throw new \LogicException("Wrong rawItem: No '$field' field in $rawItem[ID]");
            }
        }


        return true;
    }

    protected function getSeedDataFromProperties(array $rawItem): array
    {
        $properties = $rawItem["PROPERTIES"];

        $oldManufacturerId = $properties["brand"]["VALUE"] ?? null;
        $manufacturer = $this->manufacturers->where("_old_id", $oldManufacturerId)->first();

        $loopProductProduct = function (array $otherProductsIds): array {
            $newOtherProductsIds = [];
            foreach ($otherProductsIds as $id) {
                $newOtherProduct = $this->productSeedsByOldId->get($id);
                if (! $newOtherProduct) {
//                    dump("Failed to find other product with old id: $id");
//                    dump($otherProductsIds);
                    continue;
                }
                $newOtherProductsIds[] = $newOtherProduct["id"];
            }

            return $newOtherProductsIds;
        };

        $oldAccessoriesIds = ! empty($properties["accessories"]["VALUE"]) ? $properties["accessories"]["VALUE"] : [];
        $newAccessoriesIds = $loopProductProduct($oldAccessoriesIds);

        $oldSimilarIds = ! empty($properties["similar"]["VALUE"]) ? $properties["similar"]["VALUE"] : [];
        $newSimilarIds = $loopProductProduct($oldSimilarIds);

        $oldRelatedIds = ! empty($properties["sopr"]["VALUE"]) ? $properties["sopr"]["VALUE"] : [];
        $newRelatedIds = $loopProductProduct($oldRelatedIds);

        $oldWorksIds = ! empty($properties["work"]["VALUE"]) ? $properties["work"]["VALUE"] : [];
        $newWorkIds = $loopProductProduct($oldWorksIds);

        $seo = [
            "h1" => $properties["custom_h1"]["VALUE"] ?? null,
            "title" => $properties["custom_title"]["VALUE"] ?? null,
            "keywords" => $properties["meta_keywords"]["VALUE"] ?? null,
            "description" => $properties["meta_description"]["VALUE"] ?? null,
        ];

        $coefficient = $properties["koef_price"]["VALUE"];
        $coefficient_description = $properties["koef_price"]["DESCRIPTION"];

        $price_name = $properties["rename_price"]["VALUE"];

        $informational_prices = [];
        $_oldInfoPrices = $properties["info_price"];
        $__ipValues = ! empty($_oldInfoPrices["VALUE"]) ? $_oldInfoPrices["VALUE"] : [];
        $__ipDescriptions = $_oldInfoPrices["DESCRIPTION"];
        foreach ($__ipValues as $index => $infoPrice) {
            $informational_prices[] = [
                "price" => $infoPrice,
                "name" => $__ipDescriptions[$index] ?? null,
            ];
        }

        $admin_comment = $properties["auxiliary"]["VALUE"];

        $price_purchase = $properties["purchase"]["VALUE"];
        $price_purchase_currency_name = $properties["purchase"]["DESCRIPTION"];

        $unit = $properties["package"]["VALUE"];

        $is_in_stock = empty($properties["order"]["VALUE"]); // если не "на заказ", то значит, товар на складе

        return [
            "manufacturer_id" => $manufacturer ? $manufacturer["id"] : null,
            "seo" => $seo,
            "accessoriesIds" => $newAccessoriesIds,
            "similarIds" => $newSimilarIds,
            "relatedIds" => $newRelatedIds,
            "workIds" => $newWorkIds,
            "coefficient" => $coefficient,
            "coefficient_description" => $coefficient_description,
            "price_name" => $price_name,
            "informational_prices" => $informational_prices,
            "admin_comment" => $admin_comment,
            "price_purchase" => $price_purchase,
            "price_purchase_currency_name" => $price_purchase_currency_name,
            "unit" => $unit,
            "is_in_stock" => $is_in_stock,

            "is_available" => true,

            "_old_manufacturer_id" => $oldManufacturerId,
            "_old_accessories_ids" => $oldAccessoriesIds,
            "_old_similar_ids" => $oldSimilarIds,
            "_old_related_ids" => $oldRelatedIds,
            "_old_work_ids" => $oldWorksIds,
        ];
    }

    protected function getCategoryByOldId($id): ?array
    {
        return $this->categories->where("_old_id", $id)->first();
    }
}
