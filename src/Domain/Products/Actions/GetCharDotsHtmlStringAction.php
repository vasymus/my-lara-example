<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\CharType;

class GetCharDotsHtmlStringAction extends BaseAction
{
    /**
     * @param int $value
     *
     * @return string
     */
    public function execute(int $value): string
    {
        $result = '';

        for ($i = 0; $i < CharType::RATE_SIZE; $i++) {
            if ($value > $i) {
                $result .= '<span class="rate-circle rate-circle-full"></span>';
            } else {
                $result .= '<span class="rate-circle rate-circle-empty"></span>';
            }
        }

        $result = sprintf('<div class="dotted_line">%s</div>', $result);

        return $result;
    }
}
