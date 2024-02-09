<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::latest()->paginate(10);
        $data = compact('brands');
        return view('admin.brands.brands')->with($data);
    }

    public function create(){
        $title = "Add Brand";
        $url = url('admin/brand/store');
        $data = compact('title','url');
        return view('admin.brands.create_brand')->with($data);
    }

    public function store(Request $request){

        $response=[];

        try {
            $request->validate(
                [
                    "name"=> "required",
                    "slug"=>"required|unique:brands",
                    "status"=>"required",
                ],
                [
                    "name.required"=> "The brand name is Empty",
                    "slug.required"=> "The brand slug is empty.",
                    "slug.unique"=> "The brand slug is already present. Please enter different slug",
                    "slug.status"=> "The brand status is empty.",
                ]
            );

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $response = [
                'success' => true,
                'message' => 'Brand created successfully.',
            ];
            $request->session()->flash('success',$response['message']);
        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'message' => $e->validator->errors(),
            ];
        }

        return response()->json($response);

    }

    public function edit($id){
        $brand = Brand::find($id);
        if(is_null($brand)){
            return redirect()->route('brand.all')->with('error','Trying to access a brand which is not present');
        }else{
            $title = "Edit Brand";
            $url = url('admin/brand/update/').'/'.$id;
            $data = compact('title','url','brand');
            return view('admin.brands.create_brand')->with($data);
        }
    }

    public function update($id, Request $request){
        $response=[];
        $brand = Brand::find($id);
        try {
            $request->validate(
                [
                    "name"=> "required",
                    "slug"=>"required|unique:brands,slug,".$brand->id.",id", // this line will check if there is any other same slug except which, we are editing.
                    "status"=>"required",
                ],
                [
                    "name.required"=> "The brand name is Empty",
                    "slug.required"=> "The brand slug is empty.",
                    "slug.unique"=> "The brand slug is already present. Please enter different slug",
                    "slug.status"=> "The brand status is empty.",
                ]
            );

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $response = [
                'success' => true,
                'message' => 'Brand updated successfully.',
            ];
            $request->session()->flash('success',$response['message']);
        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'message' => $e->validator->errors(),
            ];
        }

        return response()->json($response);
    }

    public function delete($id, Request $request){
        $brand = Brand::find($id);
        $response=[];
        if(empty($brand)){
            $request->session()->flash('Error','Trying to access a brand which is not present');
            $response= [
                'status'=>false,
                'notFound'=>true,
                'message'=>'Brand not found'
            ];
        }else{
            $brand->delete();
            $request->session()->flash('success','Brand deleted successfully');
            $response = [
                'status'=>true,
                'message'=>'Brand deleted successfully'
            ];
        }

        return response()->json($response);

    }
}
