<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function create(){
        $title = "Add Sub-category";
        $url = url('admin/sub-category/store');
        $data = compact('title','url');
        return view('admin.sub_category.sub_category_create')->with($data);
    }
}
