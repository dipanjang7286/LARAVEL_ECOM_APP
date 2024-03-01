<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TempImagesController extends Controller
{
    public function create( Request $request){
        $image = $request->image;
        if(!empty($image)){
            $extension = $image->getClientOriginalExtension();
            $newName = time().'.'.$extension;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp', $newName);

            // Generate thumbnail
            $sourcepath = public_path() . '/temp/' . $newName;
            $destinationPath = public_path() . '/temp/thumb/' . $newName;
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcepath);
            $image->resize(300, 275);
            $image->save($destinationPath);

            return response()->json([
                'status'=>true,
                'image_id'=>$tempImage->id,
                'imagePath'=>asset('/temp/thumb/' . $newName),
                'message'=>"Image uploaded successfully"
            ]);
        }
    }
}
