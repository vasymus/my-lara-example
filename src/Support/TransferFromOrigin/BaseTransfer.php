<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

abstract class BaseTransfer
{
    use HasTransfer;
    use HasHtmlParsing;

    public const _GUID_KEY_KEY = "key";
    public const _GUID_KEY_SELECTOR = "selector";
    public const _GUID_KEY_ATTRIBUTE = "attribute";
    public const _GUID_KEY_CALLBACK = "callback";
    public const _GUID_KEY_PATTERN = "pattern";
    public const _GUID_KEY_MATCH_INDEX = "matchIndex";

    /** @var \Support\TransferFromOrigin\Fetcher */
    protected $fetcher;

    /**
     * @param string $site
     * @param string|null $username
     * @param string|null $password
     * @param \Support\TransferFromOrigin\Fetcher|null $fetcher
     * */
    public function __construct(
        string $site = "http://union.parket-lux.ru",
        ?string $username = "parket",
        ?string $password = "parket",
        $fetcher = null
    ) {
        $this->site = $site;
        $this->fetcher = $fetcher !== null ? $fetcher : new Fetcher();
        $this->fetcher->setUsername($username);
        $this->fetcher->setPassword($password);
    }

    abstract public function transfer();

    /**
     * Fetch image from site and store it on local disk
     *
     * @param string $location
     * @param int $itemId
     * @param string $entity
     *
     * @return string Full image url on local disk
     * */
    public function fetchAndStoreFile(string $location, int $itemId, string $entity): ?string
    {
        $file = $this->fetchFile($location);
        $oldFileName = basename($location);
        $path = $this->getStdStoragePath($oldFileName, $itemId, $entity);

        return $this->storeFile($path, $file);
    }

    public function fetchAndStoreFileToPath(string $location, string $storagePath): ?string
    {
        $file = $this->fetchFile($location);

        return $this->storeFile($storagePath, $file);
    }

    public function fetchFile(string $location)
    {
        $this->pageUrl = $location;

        $this->fetcher->setUrl($this->getUrl());

        return $this->fetcher->fetch();
    }

    public function fetchHtml(string $location): ?string
    {
        $this->pageUrl = ltrim($location, "/\\");

        $this->fetcher->setUrl($this->getUrl());

        return $this->fetcher->fetch();
    }

    public function storeFile($path, $file): ?string
    {
        $isSaved = Storage::put($path, $file);

        if (! $isSaved) {
            dump("Failed to save image: $path");

            return null;
        }

        return $path;
    }

    public function getStdStoragePath(string $oldFileName, int $itemId, string $entity): string
    {
        $folder = $this->getStdStorageFolder($entity);
        $fileName = $this->getStdFileName($oldFileName, (string)$itemId);

        return "$folder/$fileName";
    }

    public function getStdStorageFolder(string $entity): string
    {
        return "seeds/$entity/media";
    }

    public function getStdFileName(string $oldFileName, string $itemId): string
    {
        $extension = pathinfo($oldFileName)['extension'] ?? null;

        return $extension ? "$itemId.$extension" : "$itemId";
    }
}
