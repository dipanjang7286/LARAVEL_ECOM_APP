<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(){
        return view('admin.products.products');
    }

    public function create(){
        $title = "Add Product";
        $category = Category::orderBy('name', 'ASC')->get();
        $brand = Brand::orderBy('name','ASC')->get();
        $url = url('admin/product/store');
        $data = compact('title','category','brand','url');
        return view('admin.products.create_product')->with($data);
    }

    public function store(Request $request){
        // dd($request->image_array);
        // exit();
        $response=[];
        try {
            $request->validate(
                [
                    "title"=> "required",
                    "slug"=>"required|unique:products",
                    "category"=>"required",
                    "featuredProduct"=>"required|in:Yes,No",
                    "price"=>"required|numeric",
                    "sku"=>"required|unique:products",
                    "trackQuantity"=>"required|in:Yes,No",
                    "quantity" => ($request->trackQuantity && $request->trackQuantity == 'Yes') ? 'required|numeric' : '', // Conditional validation rule for quantity
                ],
                [
                    "title.required"=> "The product title is empty",
                    "slug.required"=> "The product slug is empty.",
                    "slug.unique"=> "The product slug is already present. Please enter different slug",
                    "category.required"=> "The product category is empty",
                    "featuredProduct.required"=> "The feature product is not selected",
                    "price.required"=> "The product price is empty",
                    "price.numeric" =>"The product price must be a number",
                    "sku.required"=> "The product sku is empty",
                    "sku.unique"=> "The product sku is already present. Please enter different sku",
                    "trackQuantity.required"=> "The product track quantity is should be checked",
                    "quantity.required" => "The product quantity is required when track quantity is checked",
                    "quantity.numeric" => "The product quantity must be a number",
                    
                ]
            );

            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->comAtprice;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->subCategory;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->featuredProduct;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_quantity = $request->trackQuantity;
            $product->quantity = $request->quantity;
            $product->status = $request->status;
            $product->save();

            if(!empty($request->image_array)){
                foreach($request->image_array as $tempImageId){
                    $tempImageInfo = TempImage::find($tempImageId);
                    $extensionArray = explode('.', $tempImageInfo->name);
                    $extension = last($extensionArray); // like jpg, png

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $extension;
                    // $imegeName example : 1-1-12334.jpg
                    $productImage->image = $imageName;
                    $productImage->save();

                    // generate thumbnails
                    // for large image
                    $sourcepath = public_path() . '/temp/' . $tempImageInfo->name;
                    $destinationPathForLarge = public_path() . '/uploads/product/large/' . $tempImageInfo->name;
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($sourcepath);
                    $image->scale(1400, null);
                    $image->save($destinationPathForLarge);

                    // small image
                    $destinationPathForSmall = public_path() . '/uploads/product/small/' . $tempImageInfo->name;
                    $image->cover(300, 300);
                    $image->save($destinationPathForSmall);
                }
            }


            $response = [
                'success' => true,
                'message' => 'Product created successfully.',
            ];
        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'message' => $e->validator->errors(),
            ];
        }

        return response()->json($response);
    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(){

    }
}
