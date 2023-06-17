<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Facades\MediaUploader;

class ProcessMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $webp;
    protected $quality;

    /*
     * Create a new job instance.
     *
     * @param File|UploadedFile|string $file
     * @param Model $model
     * @param Array|string $tags
     */
    public function __construct(private $file, private $model, private $tags)
    {
        $size = is_string($file) ? File::size($file) : $file->getSize();

        $this->quality = $size >= 204800 ? (204800 * 100) / $size : 95;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->webp = Image::make($this->file)->encode('webp', $this->quality);

        Storage::disk('uploads')->put("{$this->model->getTable()}/{$this->webp->basename}.webp", $this->webp);

        $this->file = Storage::disk('uploads')->path("{$this->model->getTable()}/{$this->webp->basename}.webp");

        $media = MediaUploader::fromSource($this->file)
            ->toDisk('public')
            ->toDirectory($this->model->getTable())
            ->useHashForFilename()
            ->onDuplicateUpdate()
            ->upload();

        $this->model->attachMedia($media, $this->tags);;

        Storage::disk('uploads')->delete("{$this->model->getTable()}/{$this->webp->basename}.webp");
    }
}
