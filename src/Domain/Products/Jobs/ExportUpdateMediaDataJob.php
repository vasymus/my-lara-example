<?php

namespace Domain\Products\Jobs;

use App\Constants;
use DateTimeInterface;
use Domain\Common\Models\CustomMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\Support\File;

class ExportUpdateMediaDataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $id;

    public ?DateTimeInterface $deleteTime;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param \DateTimeInterface|null $deleteTime
     */
    public function __construct(int $id, DateTimeInterface $deleteTime = null)
    {
        $this->id = $id;
        $this->deleteTime = $deleteTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var \Domain\Common\Models\CustomMedia $media */
        $media = CustomMedia::query()->findOrFail($this->id);
        if (! $this->finishArchive($media)) {
            $this->release(60 * 2);

            return;
        }
        $media->size = filesize($media->getPath());
        $media->mime_type = File::getMimeType($media->getPath());
        if ($this->deleteTime) {
            $media->delete_time = $this->deleteTime;
        }
        $media->save();
    }

    /**
     * @param \Domain\Common\Models\CustomMedia $media
     *
     * @return bool
     */
    protected function finishArchive(CustomMedia $media): bool
    {
        $realMimeType = File::getMimeType($media->getPath());

        return $realMimeType === Constants::MIME_ZIP;
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return Carbon::now()->addDays(1);
    }
}
