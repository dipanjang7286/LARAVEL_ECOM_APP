<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    public function index(){

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

    public function edit(){
        
    }

    public function update(){
        
    }

    public function delete(){
        
    }
}
