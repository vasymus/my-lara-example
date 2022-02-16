<?php

namespace Domain\Common\Actions;

class MoveOrderingItemAction extends BaseAction
{
    /**
     * @param array[] $items
     * @param int $index
     * @param bool $isUp
     * @param bool $descending
     *
     * @return array[]
     */
    public function execute(array $items, int $index, bool $isUp, bool $descending = false): array
    {
        $item = $items[$index] ?? null;
        if (! $item) {
            return $items;
        }
        $prevItem = $items[$index - 1] ?? null;
        $nextItem = $items[$index + 1] ?? null;

        if ($isUp && ! $prevItem) {
            return $items;
        }

        if (! $isUp && ! $nextItem) {
            return $items;
        }
        $currentOrdering = $item['ordering'];

        if ($isUp) {
            $prevOrdering = $prevItem['ordering'];
            $prevItem['ordering'] = $currentOrdering;
            $item['ordering'] = $prevOrdering;
            $items[$index - 1] = $prevItem;
        } else {
            $nextOrdering = $nextItem['ordering'];
            $nextItem['ordering'] = $currentOrdering;
            $item['ordering'] = $nextOrdering;
            $items[$index + 1] = $nextItem;
        }

        $items[$index] = $item;

        $items = collect($items)->sortBy('ordering', SORT_REGULAR, $descending)->values()->all();

        return $items;
    }
}
