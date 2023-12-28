<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index(){ // show all category
        $category = Category::latest()->paginate(10);
        $data = compact('category');
        return view('admin.category.category')->with($data);
    }

    public function create(){ // show add category page
        $title = "Add Category";
        $url = url('admin/category/store');
        $data = compact('title','url');
        return view('admin.category.category_create')->with($data);
    }

    public function store(Request $request){ // store category in db
        $request->validate(
            [
                "name"=> "required",
                "slug"=>"required|unique:categories",
                "status"=>"required",
            ],
            [
                "name.required"=> "The category name is Empty",
                "slug.required"=> "The category slug is empty.",
                "slug.unique"=> "The category slug is already present. Please enter different slug",
                "slug.status"=> "The category status is empty.",
            ]
        );

        Category::insert([
            "name"=>$request->name,
            "slug"=>$request->slug,
            "status"=>$request->status,
        ]);
        // $request->session()->flush('success','Category added successfully');
        return redirect()->back();

    }

    public function edit($id){ // show the edit page
        $title = "Update Category";
        $url = url("admin/category/update/").$id;
        $data = compact('title','url');
        return view('admin.category.category_create')->with($data);
    }

    public function update(){ // update particular category in db

    }

    public function delete(){ // delete the category

    }


}
