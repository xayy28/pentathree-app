<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploadService
{
    public function storePublic(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1600,
        ?int $maxHeight = null,
        int $quality = 82
    ): string {
        $directory = trim($directory, '/');
        $relativePath = $directory.'/'.$this->filename();

        File::ensureDirectoryExists(public_path($directory));

        $this->optimize($file, $maxWidth, $maxHeight, $quality)
            ->save(public_path($relativePath));

        return $relativePath;
    }

    public function storeDisk(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        int $maxWidth = 1600,
        ?int $maxHeight = null,
        int $quality = 82
    ): string {
        $relativePath = trim($directory, '/').'/'.$this->filename();

        Storage::disk($disk)->put(
            $relativePath,
            $this->optimize($file, $maxWidth, $maxHeight, $quality)->toString()
        );

        return $relativePath;
    }

    private function optimize(
        UploadedFile $file,
        int $maxWidth,
        ?int $maxHeight,
        int $quality
    ): EncodedImageInterface {
        $image = Image::decodePath($file->getRealPath());

        $image->scaleDown(width: $maxWidth, height: $maxHeight);

        return $image->encodeUsingMediaType('image/webp', quality: $quality);
    }

    private function filename(): string
    {
        return Str::uuid()->toString().'.webp';
    }
}
