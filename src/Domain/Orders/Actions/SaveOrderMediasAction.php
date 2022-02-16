<?php

namespace Domain\Orders\Actions;

use Domain\Common\Models\CustomMedia;
use Domain\Orders\Models\Order;

class SaveOrderMediasAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param array[] $files @see {@link \Domain\Common\DTOs\FileDTO}
     * @param string $collectionName
     *
     * @return void
     */
    public function execute(Order $order, array $files, string $collectionName): void
    {
        // delete
        $mediasIds = collect($files)->pluck('id')->filter()->values()->toArray();
        $order->getMedia($collectionName)->each(function (CustomMedia $customMedia) use ($mediasIds) {
            if (! in_array($customMedia->id, $mediasIds)) {
                $customMedia->delete();
            }
        });

        foreach ($files as $fileDTO) {
            // updating
            if ($fileDTO['id'] !== null) {
                /** @var \Domain\Common\Models\CustomMedia $file */
                $file = $order->getMedia($collectionName)->first(fn (CustomMedia $customMedia) => $fileDTO['id'] === $customMedia->id);
                $file->name = $fileDTO['name'] ?: $fileDTO['file_name'];
                $file->save();

                continue;
            }
            // creating
            $fileAdder = $order
                ->addMedia($fileDTO['path'])
                ->preservingOriginal()
                ->usingFileName($fileDTO['file_name'])
                ->usingName($fileDTO['name'] ?? $fileDTO['file_name'])
            ;
            $fileAdder->toMediaCollection($collectionName);
        }
    }
}
