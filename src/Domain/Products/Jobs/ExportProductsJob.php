<?php

namespace Domain\Products\Jobs;

use DateInterval;
use Domain\Products\Actions\ExportImport\ExportProductsAction;
use Domain\Users\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const ARCHIVE_FILE_NAME_PREFIX = 'product-export';

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var int[]
     */
    protected array $productsIds;

    /**
     * Create a new job instance.
     *
     * @param int[] $productsIds
     *
     * @return void
     */
    public function __construct(array $productsIds)
    {
        $this->productsIds = $productsIds;
    }

    /**
     * Execute the job.
     *
     * @param \Domain\Products\Actions\ExportImport\ExportProductsAction $exportProductsAction
     *
     * @return void
     */
    public function handle(ExportProductsAction $exportProductsAction)
    {
        // because of some bug, can't create temporary file
        // and then add it to media collection

        // first, create empty file
        $filePath = tempnam('/tmp', 'zip');

        // second, add to to media library
        $name = sprintf(
            '%s--%s.zip',
            self::ARCHIVE_FILE_NAME_PREFIX,
            Carbon::now()->format('Y-m-d--H-i-s')
        );
        $centralAdmin = Admin::getCentralAdmin();
        $media = $centralAdmin
            ->addMedia($filePath)
            ->setFileName($name)
            ->toMediaCollection(Admin::MC_EXPORT_PRODUCTS);

        // third, dispatch a update media and dispatch clear jobs which run after overwriting (see below)
        // has to do this workaround because of bug
        $interval = new DateInterval('P1D');
        $deleteTime = Carbon::now()->add($interval);
        ExportUpdateMediaDataJob::dispatch($media->id, $deleteTime)->delay(new DateInterval('PT3M'));
        // cleaning
        ExportClearJob::dispatch($media->id)->delay($interval);

        // fourth, overwrite content of added file with zip archive
        $exportProductsAction->execute($this->productsIds, $media->getPath());
    }
}
