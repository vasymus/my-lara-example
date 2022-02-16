<?php

namespace Support\TransferFromOrigin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;
use Symfony\Component\DomCrawler\Crawler;

class TransferFAQ2 extends BaseTransfer
{
    public function transfer()
    {
        // TODO: Implement transfer() method.
    }

    public function parsePages()
    {
        $seeds = [];

        $pages = 10;

        for ($i = 0; $i < $pages; $i++) {
            $folder = "seeds/faq/new/pages/$i";
            $files = File::files(storage_path("app/$folder"));
            foreach ($files as $j => $file) {
                $bn = $file->getBasename();
                $html = Storage::get("$folder/$bn");
                $seeds = array_merge($seeds, $this->parsePage($html));
            }
        }

        Storage::put("seeds/faq/new/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    public function parsePage(string $html)
    {
        $parsed = [];

        $id1 = $this->getIncrementId();

        $crawler = (new Crawler($html));

        $name1 = $crawler->filter("h1")->text();
        $slug1 = $crawler->filter(".form-horizontal")->attr("data-action");
        $slug1 = str_slug(urldecode(basename($slug1)));

        $date1 = $crawler->filter(".news-detail div")->eq(0)->text();

        $question1 = $this->hadleNodeHtml((new Crawler($html))->filter(".news-detail .detail_question")->eq(0));
        $answer1 = $this->hadleNodeHtml((new Crawler($html))->filter(".news-detail .detail_answer")->eq(0));

        $parsed[] = [
            "id" => $id1,
            "name" => $name1,
            "slug" => $slug1,
            "question" => $question1,
            "answer" => $answer1,
            "created_at" => $date1,
            "parent_id" => null,
        ];


        $name2Node = $crawler->filter(".detail_author");
        $question2Crawler = (new Crawler($html))->filter(".news-detail .detail_question")->eq(1);
        $answer2Crawler = (new Crawler($html))->filter(".news-detail .detail_answer")->eq(0);

        if ($name2Node->count() && $question2Crawler->count() && $answer2Crawler->count()) {
            $id2 = $this->getIncrementId();
            $name2 = $name2Node->text();
            $date2 = $crawler->filter(".news-detail div")->eq(4)->text();


            $question2 = $question2Crawler->count() > 0 ? $this->hadleNodeHtml($question2Crawler) : "";


            $answer2 = $answer2Crawler->count() > 0 ? $this->hadleNodeHtml($answer2Crawler) : "";

            $parsed[] = [
                "id" => $id2,
                "name" => $name2,
                "slug" => null,
                "question" => $question2,
                "answer" => $answer2,
                "created_at" => $date2,
                "parent_id" => $id1,
            ];
        }

        return $parsed;
    }

    protected function hadleNodeHtml(Crawler $crawler): string
    {
        $crawler
            ->filter("img")
            ->each(function (Crawler $imgNode) {
                $oldSrc = ltrim($imgNode->attr("src"), "/");
                /** @var Builder $builder */
                $builder = Curl::to("https://parket-lux.ru/$oldSrc");
                $img = $builder->get();
                $newSrc = "seeds/faq/new/media/$oldSrc";
                Storage::put($newSrc, $img);
                /** @var \DOMElement $domEl */
                $domEl = $imgNode->getNode(0);
                $domEl->setAttribute("src", $newSrc);
            })
        ;
        $crawler->filter("a")
            ->each(function (Crawler $anchorNode) {
                $attr = $anchorNode->attr("href");
                $newAttr = str_replace(["https://parket-lux.ru/", "http://parket-lux.ru/", "parket-lux.ru/"], "/", $attr);
                /** @var \DOMElement $domEl */
                $domEl = $anchorNode->getNode(0);
                $domEl->setAttribute("href", $newAttr);
            })
        ;

        return $crawler->html();
    }

    public function storePages()
    {
        $linksPages = require(storage_path("app/seeds/faq/new/raw-links-pages.php"));

        $faqPath = "https://parket-lux.ru/";

        foreach ($linksPages as $i => $page) {
            foreach ($page as $j => $nameHref) {
                $href = ltrim($nameHref["href"], "/");
                $pageUrl = "{$faqPath}{$href}";

                /** @var Builder $builder */
                $builder = Curl::to($pageUrl);

                $html = $builder->get();

                if (! $html) {
                    dump("Failed to fetch $pageUrl");
                }

                Storage::put($this->getPageStorageLink($i, $j), $html);
            }
        }
    }

    public function storeLinks()
    {
        $this->fetchAndStoreLinksPages();
        $this->parseAndStoreLinks();
    }

    public function fetchAndStoreLinksPages(int $i = 1)
    {
        $faqPath = "https://parket-lux.ru/faq/";
        $pageQuery = "PAGEN_1";
        $pages = 23;

        for (; $i <= $pages; $i++) {
            $pageUrl = "$faqPath?$pageQuery=$i";
            /** @var Builder $builder */
            $builder = Curl::to($pageUrl);

            $html = $builder->get();

            if (! $html) {
                dump("Failed to fetch $pageUrl");
            }

            Storage::put($this->getLinkPageStoragePath($i), $html);
        }
    }

    public function parseAndStoreLinks(int $i = 1)
    {
        $result = [];

        $pages = 23;

        for (; $i <= $pages; $i++) {
            $html = Storage::get($this->getLinkPageStoragePath($i));

            $crawler = (new Crawler($html));

            $resultItem = [];

            $crawler->filter(".faq-section .question .detail_author a")->each(function (Crawler $node) use (&$resultItem) {
                $resultItem[] = [
                    "name" => $node->text(),
                    "href" => $node->attr("href"),
                ];
            });

            $result[] = $resultItem;
        }

        $php = "<?php\n\nreturn " . var_export($result, true) . ";\n";

        Storage::put("seeds/faq/new/raw-links-pages.php", $php);
    }

    public function getLinkPageStoragePath(int $i): string
    {
        return "seeds/faq/new/links-pages/$i.html";
    }

    public function getPageStorageLink(int $i, int $j): string
    {
        return "seeds/faq/new/pages/$i/$j.html";
    }
}
