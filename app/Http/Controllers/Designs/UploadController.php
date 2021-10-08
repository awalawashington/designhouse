<?php

namespace App\Http\Controllers\Designs;

use App\Jobs\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,gif,bmp,png', 'max:2048']
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathName();

        //get the original file name and replace any spaces with _
        $filename = time()."_".  preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move image to the temporary storage
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        //create the database record for the design
        $design = auth()->user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk')
        ]);

        //dispatch a job to handle the image manipulation
        $this->dispatch(new UploadImage($design));
        
        
        return response()->json($design, 200);
    }
}
