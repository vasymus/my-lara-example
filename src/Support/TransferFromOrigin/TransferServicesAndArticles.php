<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class TransferServicesAndArticles extends BaseTransfer
{
    /**
     * @param string|null $site
     * @param string|null $username
     * @param string|null $password
     * @param Fetcher|null $fetcher
     * */
    public function __construct(?string $site = "http://union.parket-lux.ru", string $username = "parket", string $password = "parket", $fetcher = null) // // @phpstan-ignore-line
    {
        parent::__construct("https://parket-lux.ru", null, null, $fetcher);
    }

    public function transfer()
    {
        $raw = require(storage_path("app/seeds/pages/raw.php"));

        $seeds = [];

        foreach ($raw as $item) {
            $seed = $this->handleRawSeedItem($item);
            if (! empty($seed)) {
                $seeds[] = $seed;
            }
        }

        Storage::put("seeds/pages/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    public function handleRawSeedItem(array $item): ?array
    {
        $url = $item["link"];
        $images = $item["images"];
        $html = $this->fetchHtml($url);
        if (! $html) {
            dump("Failed to fetch html $url");

            return null;
        }
        $this->handleStoreHtml($url, $html);

        $seo = $this->parseSeo($html);
        $oldNewImages = [];
        foreach ($images as $oldImageSrc) {
            $newImageSrc = $this->fetchAndStoreImage($oldImageSrc);
            if ($newImageSrc) {
                $oldNewImages[$oldImageSrc] = $newImageSrc;
            }
        }
        $updatedHtml = $this->getHtmlWithUpdatedImgSrc($html, $oldNewImages);
        $onlyContentFromUpdatedHtml = $this->getOnlyContent($updatedHtml);

        if ($this->isArticle($url)) {
            $path = "seeds/pages/new/articles/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $onlyContentFromUpdatedHtml);
        } else {
            $path = "seeds/pages/new/services/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $onlyContentFromUpdatedHtml);
        }

        if (! $isSaved) {
            dump("Failed to save new html $url");

            return null;
        }

        return [
            "name" => $item["name"],
            "slug" => basename($url),
            "html" => $path,
            "seo" => $seo,
            "is_active" => true,
            "description" => null,
            "is_article" => $this->isArticle($url),
            "images" => array_values($oldNewImages),
            "_oldUrl" => $url,
        ];
    }

    public function getOnlyContent(string $html): string
    {
        $result = "";
        $crawler = new Crawler($html);
        $crawler->filter("article.article-content")->each(function (Crawler $node) use (&$result) {
            $result = $node->outerHtml();
        });

        return $result;
    }

    public function parseSeo(string $html): array
    {
        $crawler = new Crawler($html);
        $result = [
            "title" => null,
            "description" => null,
            "keywords" => null,
            "h1" => null,
        ];
        $crawler->filter("meta")->each(function (Crawler $node) use (&$result) {
            if ($node->attr("name") === "keywords") {
                $result["keywords"] = $node->attr("content");
            }
            if ($node->attr("name") === "description") {
                $result["description"] = $node->attr("content");
            }
        });
        $crawler->filter("title")->each(function (Crawler $node) use (&$result) {
            $result["title"] = $node->text();
        });
        $crawler->filter("h1")->each(function (Crawler $node) use (&$result) {
            $result["h1"] = $node->text();
        });

        return $result;
    }

    public function getHtmlWithUpdatedImgSrc(string $html, array $oldNewImages): string
    {
        $crawler = new Crawler($html);

        foreach ($oldNewImages as $old => $new) {
            $crawler->filter("img")->each(function (Crawler $node) use ($old, $new) {
                if ($node->attr("src") === $old) {
                    $node->getNode(0)->setAttribute("src", $new); // @phpstan-ignore-line
                }
            });
        }

        return $crawler->html();
    }

    public function handleStoreHtml(string $url, string $html): ?string
    {
        if ($this->isArticle($url)) {
            $path = "seeds/pages/old/articles/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $html);
        } else {
            $path = "seeds/pages/old/services/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $html);
        }

        if (! $isSaved) {
            dump("Failed to save old html $url");

            return null;
        }

        return $path;
    }

    protected function isArticle(string $url): bool
    {
        return str_contains($url, "articles");
    }

    public function fetchAndStoreImage(string $url): ?string
    {
        $url = parse_url($url)["path"];

        return $this->fetchAndStoreFileToPath($url, "seeds/pages/images/" . ltrim($url, "/\\"));
    }
}
