<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        $subCategory = SubCategory::select('sub_categories.*', 'categories.name as category_name')->latest('id')->join('categories','categories.id','sub_categories.category_id')->paginate(10);
        $data = compact('subCategory');
        return view('admin.sub_category.sub-category')->with($data);
    }
    public function create(){
        $title = "Add Sub-category";
        $url = url('admin/sub-category/store');
        $category = Category::orderBy('name', 'ASC')->get();
        $data = compact('title','url', 'category');
        return view('admin.sub_category.sub_category_create')->with($data);
    }

    public function store(Request $request){
        $request->validate(
            [
                "category"=>"required",
                "name"=> "required",
                "slug"=>"required|unique:sub_categories",
                "status"=>"required",
            ],
            [
                "category.required"=> "Please select a category",
                "name.required"=> "The sub-category name is Empty",
                "slug.required"=> "The sub-category slug is empty.",
                "slug.unique"=> "The sub-category slug is already present. Please enter different slug",
                "slug.status"=> "The sub-category status is empty.",
            ]
        );

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->save();

        return redirect()->route('sub-category.all')->with('success','Sub-category added successfully');
    }

    public function edit($id){ // show the edit page
        $subCategory = SubCategory::find($id);
        $category = Category::orderBy('name', 'ASC')->get();
        if(is_null($subCategory)){
            return redirect()->route('sub-category.all');
        }else{
            $title = "Update Sub-category";
            $url = url("admin/sub-category/update").'/'.$id;
            $data = compact('subCategory','category','title','url');
            return view('admin.sub_category.sub_category_create')->with($data);
        }
    }
}
