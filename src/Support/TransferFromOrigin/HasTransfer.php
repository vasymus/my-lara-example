<?php

namespace Support\TransferFromOrigin;

trait HasTransfer
{
    public $site;

    public $pageUrl;

    public $pageKey;

    public $pageNum;

    protected $increment = 0;

    public function getUrl(): string
    {
        $url = "{$this->site}/{$this->pageUrl}";
        if ($this->pageNum) {
            $url .+"?{$this->pageKey}={$this->pageNum}";
        }

        return $url;
    }

    public function getIncrementId(): int
    {
        $this->increment++;

        return $this->increment;
    }
}
