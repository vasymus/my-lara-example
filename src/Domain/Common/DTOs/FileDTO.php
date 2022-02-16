<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\CustomMedia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use RuntimeException;
use Spatie\DataTransferObject\DataTransferObject;
use Support\H;

class FileDTO extends DataTransferObject
{
    protected bool $ignoreMissing = true;

    public ?int $id;

    public ?string $mime_type;

    public ?string $mime_type_name;

    public ?string $name;

    public ?string $file_name;

    public ?string $path;

    public ?string $url;

    public ?string $uuid;

    public static function fromCustomMedia(CustomMedia $media): self
    {
        if (! $media->id) { // otherwise $media->getPath() will throw type error
            return new self([]);
        }

        return new self([
            "id" => $media->id,
            "mime_type" => $media->mime_type,
            "mime_type_name" => $media->mime_type_name,
            "file_name" => $media->file_name,
            "name" => $media->name,
            "path" => $media->getPath(),
            "url" => $media->getUrl(),
            "uuid" => $media->uuid,
        ]);
    }

    public static function copyFromCustomMedia(CustomMedia $media): self
    {
        if (! $media->id) { // otherwise $media->getPath() will throw type error
            return new self([]);
        }

        return new self([
            "id" => null,
            "mime_type" => $media->mime_type,
            "mime_type_name" => $media->mime_type_name,
            "file_name" => $media->file_name,
            "name" => $media->name,
            "path" => $media->getPath(),
            "url" => $media->getUrl(),
            "uuid" => Str::uuid()->toString(),
        ]);
    }

    public static function fromTemporaryUploadedFile(TemporaryUploadedFile $temporaryUploadedFile): self
    {
        try {
            $url = $temporaryUploadedFile->temporaryUrl();
        } catch (RuntimeException $ignored) {
            $originalName = str_replace('\\', '/', $temporaryUploadedFile->getPath());
            $pos = strrpos($originalName, '/');
            $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

            $url = URL::temporarySignedRoute(
                'livewire.preview-file',
                now()->addMinutes(30),
                ['filename' => $originalName]
            );
        }

        return new self([
            "id" => null,
            "mime_type" => $temporaryUploadedFile->getMimeType(),
            "mime_type_name" => H::getMimeTypeName($temporaryUploadedFile->getMimeType()),
            "file_name" => $temporaryUploadedFile->getClientOriginalName(),
            "name" => $temporaryUploadedFile->getClientOriginalName(),
            "path" => $temporaryUploadedFile->getRealPath(),
            "url" => $url ?? '',
            "uuid" => Str::uuid()->toString(),
        ]);
    }
}
