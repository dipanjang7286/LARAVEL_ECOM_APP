@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('product.all')}}" class="btn btn-primary">Back</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{$url}}" method="post">
                @php
                    $urlForCheck = url('').'/admin/product/store';
                    // here checking the url is for adding category or updating category
                @endphp
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" name="name" id="productName" placeholder="Enter product name" value="">
                    </div>

                    <div class="form-group">
                        <label for="productSlug">Product Slug</label>
                        <input type="text" class="form-control" name="slug" id="productSlug" placeholder="Enter category slug" value="" readonly>
                    </div>

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Please select a category</option>
                            @if (!empty($category))
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subCategory">Select Sub Category</label>
                        <select name="subCategory" id="subCategory" class="form-control">
                            <option value="">Please select a sub-category</option>
                            @if (!empty($subCategory))
                                @foreach ($subCategory as $item)
                                    <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productStatus">Status</label>
                        <select name="status" id="productStatus" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Block</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('product.all')}}" class="btn btn-danger ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        
        $('body').on('change','#productName',function(){
            let element = $(this);
            $.ajax({
                url:"{{route('getSlug')}}",
                type:'get',
                data:{title: element.val()},
                dataType:'json',
                success: function(response){
                    if(response['status']==true){
                        $('#productSlug').val(response['slug']);
                    }
                }

            })
        })
    </script>
@endsection