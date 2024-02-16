<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

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
        var_dump($request->all());
    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(){

    }
}
