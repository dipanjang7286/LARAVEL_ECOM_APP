<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        
        // Image
        if(!empty($request->image_id)){
            $tempImage = TempImage::find($request->image_id);
            $extensionArray = explode('.', $tempImage->name);
            $imageExtension = last($extensionArray);

            $newImageName = $category->id .'.'.$imageExtension;
            // copying image from temp to uploads folder
            $sourcePath = public_path().'/temp/'.$tempImage->name;
            $destinationPath = public_path().'/uploads/category/'.$newImageName;
            File::copy($sourcePath, $destinationPath);

            // Generate Image Thumbnail
            $dsetnPath = public_path().'/uploads/category/thumb/'.$newImageName;
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);
            $image->resize(450, 600);
            $image->save($dsetnPath);

            // saving image name in the db
            $category->image = $newImageName;
            $category->save();
        }
        
        return redirect()->route('category.all')->with('success','Category added successfully');

    }

    public function edit($id){ // show the edit page
        $category = Category::find($id);
        if(is_null($category)){
            return redirect()->route('category.all');
        }else{
            $title = "Update Category";
            $url = url("admin/category/update").'/'.$id;
            $data = compact('category','title','url');
            return view('admin.category.category_create')->with($data);
        }
    }

    public function update($id, Request $request){ // update particular category in db
        $category = Category::find($id);
        if(empty($category)){
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Category not found'
            ]);
        }
        $request->validate(
            [
                "name"=> "required",
                "slug"=>"required|unique:categories,slug,".$id.",id",
                "status"=>"required",
            ],
            [
                "name.required"=> "The category name is Empty",
                "slug.required"=> "The category slug is empty.",
                "slug.unique"=> "The category slug is already present. Please enter different slug",
                "slug.status"=> "The category status is empty.",
            ]
        );

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->save();

        // Image
        $oldImage = $category->image;
        if(!empty($request->image_id)){
            $tempImage = TempImage::find($request->image_id);
            $extensionArray = explode('.', $tempImage->name);
            $imageExtension = last($extensionArray);

            $newImageName = $category->id.'-'.time().'.'.$imageExtension;
            // copying image from temp to uploads folder
            $sourcePath = public_path().'/temp/'.$tempImage->name;
            $destinationPath = public_path().'/uploads/category/'.$newImageName;
            File::copy($sourcePath, $destinationPath);

            // Generate Image Thumbnail
            $dsetnPath = public_path().'/uploads/category/thumb/'.$newImageName;
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);
            $image->resize(450, 600);
            $image->save($dsetnPath);

            // saving image name in the db
            $category->image = $newImageName;
            $category->save();

            // delete old image
            File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
            File::delete(public_path().'/uploads/category/'.$oldImage);
        }

        return redirect()->route('category.all')->with('success','Category updated successfully');
    }

    public function delete($id, Request $request){ // delete the category
        $category = Category::find($id);
        if(empty($category)){
            return response()->json([
                'status'=>false,
                'notFound'=>true,
                'message'=>'Category not found'
            ]);
        }

        File::delete(public_path().'/uploads/category/thumb/'.$category->image);
        File::delete(public_path().'/uploads/category/'.$category->image);

        $category->delete();

        // return redirect()->route('category.all')->with('success','Category deleted successfully');
        
        $request->session()->flash('success','Category deleted successfully');
        return response()->json([
            'status'=>true,
            'message'=>'Category deleted successfully'
        ]);

    }


}
