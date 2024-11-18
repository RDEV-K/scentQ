<?php

namespace App\Listeners;

use App\Jobs\OptimizeImageSize;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;

class HasUploadedImageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $method = 'on'.class_basename($event);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $event);
        }
    }

    public function onImageWasUploaded(ImageWasUploaded $event)
    {
        $path = $event->path();
        $imageUrl = config('filesystems.disks.digitalocean.url').'/'.$path;
        OptimizeImageSize::dispatch($imageUrl);
    }
}
