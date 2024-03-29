<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request){
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $sourcepath = $image->getRealPath(); // this path is from local device.

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id .'-' . $productImage->id . '-' . time() . '.' . $extension; 
        $productImage->image = $imageName;
        $productImage->save();

        // generate thumbnails
        // for large image
        $destinationPathForLarge = public_path() . '/uploads/product/large/' . $imageName;
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourcepath);
        $image->scale(1400, null);
        $image->save($destinationPathForLarge);

        // small image
        $destinationPathForSmall = public_path() . '/uploads/product/small/' . $imageName;
        $image->cover(300, 300);
        $image->save($destinationPathForSmall);

        return response()->json([
            'status'=>true,
            'image_id'=> $productImage->id,
            'imagePath'=> asset('/uploads/product/small/' . $imageName),
            'message'=> "Image uploaded successfully"
        ]);
    }

    public function deleteImage(Request $request){
        $productImage = ProductImage::find($request->id);

        if(empty($productImage)){
            return response()->json([
                'status'=>false,
                'message'=> "Image not found"
            ]);
        }

        // delete image from folder
        File::delete(public_path('uploads/product/large/' . $productImage->image));
        File::delete(public_path('uploads/product/small/' . $productImage->image));

        //delete from db
        $productImage->delete();

        return response()->json([
            'status'=>true,
            'message'=> "Image deleted successfully"
        ]);
    }
}
