<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Char;
use Illuminate\Support\HtmlString;

class GetCharHtmlAction extends BaseAction
{
    protected GetCharDotsHtmlStringAction $getCharDotsHtmlStringAction;

    public function __construct(GetCharDotsHtmlStringAction $getCharDotsHtmlStringAction)
    {
        $this->getCharDotsHtmlStringAction = $getCharDotsHtmlStringAction;
    }

    public function execute(Char $char): HtmlString
    {
        if ($char->is_rate) {
            $html = $this->getCharDotsHtmlStringAction->execute((int)$char->value);
        } else {
            $html = sprintf('<div class="dotted_line">%s</div>', (string)$char->value);
        }

        return new HtmlString($html);
    }
}
