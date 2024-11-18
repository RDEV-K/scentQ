<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OptimizeImageSize implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->image = $url;
        // \Tinify\setKey(config('app.tinify_key'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Tinify\setKey(config('app.tinify_key'));
        $storageUrl = config('filesystems.disks.digitalocean.url').'/'.config('filesystems.disks.digitalocean.root');

        // Extract Image Name
        $tokens = explode('/', $this->image);
        $imageName = trim(end($tokens));

        // Image Temporary Location
        $tempLocation = 'product-images/'.$imageName;

        // Extract Image Folder Location
        $imageFolderLocation = str_replace($imageName, "", str_replace($storageUrl,"",$this->image));

        // Download the file
        $imageContents = Storage::disk(config('filesystems.default'))->get(str_replace($storageUrl,"",$this->image));
        file_put_contents(public_path($tempLocation), $imageContents);

        // Save the image file on temporary location after optimization is complete
        $source = \Tinify\fromFile(public_path($tempLocation));
        $source->toFile(public_path($tempLocation));

        // Upload to digitalocean and replace the file
        $file = Storage::disk(config('filesystems.default'))->putFileAs($imageFolderLocation, new File(public_path($tempLocation)), $imageName);

        // Delete the temporary file
        unlink(public_path($tempLocation));
        \Log::info('optimization completed for image '. $this->image);
    }
}
