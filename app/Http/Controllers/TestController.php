<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(){
        // $product = Product::first();

        $files = Storage::disk('digitalocean')->files('testing');
        return view('test', compact('files'));
    }

    public function store(Request $request){
        \Tinify\setKey("XpAcVfIMEeFaM30ZtLAHVHHJPm57jc9U");

        $image = $request->image;
        $imageLocation = 'testing/' . $image->hashName();

        $source = \Tinify\fromFile($image);
        $source->toFile($imageLocation);

        $file = Storage::disk(config('filesystems.default'))->putFile('testing', new File($imageLocation));
        unlink($imageLocation);
        return response()->json(['message' => 'File uploaded', 'file' => $file], 200);
    }

    public function optimize(){
        \Tinify\setKey("XpAcVfIMEeFaM30ZtLAHVHHJPm57jc9U");

        $product = Product::first();
        $image = $product->image['url'];

        // Extract Image Name
        $tokens = explode('/', $image);
        $imageName = trim(end($tokens));

        // Image Temporary Location
        $tempLocation = 'product-images/'.$imageName;

        // Extract Image Folder Location
        $imageFolderLocation = str_replace($imageName, "", str_replace("https://cdn.scentq.com/prod-storage/","",$image));

        // Download the file
        $imageContents = Storage::disk(config('filesystems.default'))->get(str_replace("https://cdn.scentq.com/prod-storage/","",$image));
        file_put_contents($tempLocation, $imageContents);

        // Save the image file on temporary location after optimization is complete
        $source = \Tinify\fromFile($tempLocation);
        $source->toFile($tempLocation);

        // Upload to digitalocean and replace the file
        $file = Storage::disk(config('filesystems.default'))->putFileAs($imageFolderLocation, new File($tempLocation), $imageName);

        // Delete the temporary file
        unlink($tempLocation);

        // return the response
        return response()->json([
            'success' => true,
            'old' => $image,
            'optmized' => $product->image['url']
        ], 200);
    }
}
