<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
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

        // Category::insert([
        //     "name"=>$request->name,
        //     "slug"=>$request->slug,
        //     "status"=>$request->status,
        // ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->save();

        if(!empty($request->image_id)){
            $tempImage = TempImage::find($request->image_id);
            $extensionArray = explode('.', $tempImage->name);
            $imageExtension = last($extensionArray);

            $newImageName = $category->id .'.'.$imageExtension;
            // copying image from temp to uploads folder
            $sourcePath = public_path().'/temp/'.$tempImage->name;
            $destinationPath = public_path().'/uploads/category/'.$newImageName;
            File::copy($sourcePath, $destinationPath);
            $category->image = $newImageName;
            $category->save();
        }
        
        return redirect()->route('category.all')->with('success','Category added successfully');

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
