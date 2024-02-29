<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){
        
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
        $response=[];
        try {
            $request->validate(
                [
                    "title"=> "required",
                    "slug"=>"required|unique:products",
                    "category"=>"required",
                    "featuredProduct"=>"required|in:Yes,No",
                    "price"=>"required|numeric",
                    "sku"=>"required",
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
                    "sku.required"=> "The product sku is empty",
                    "trackQuantity.required"=> "The product track quantity is should be checked",
                    "quantity.required" => "The product quantity is required when track quantity is checked",
                    "quantity.numeric" => "The product quantity must be a number",
                    
                ]
            );

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
