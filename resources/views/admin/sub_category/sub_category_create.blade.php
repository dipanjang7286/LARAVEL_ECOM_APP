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
                            <a href="{{route('sub-category.all')}}" class="btn btn-primary">Back</a>
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
                    $urlForCheck = url('').'/admin/sub-category/store';
                    // here checking the url is for adding category or updating category
                @endphp
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select name="category" id="category" class="form-control">
                            <option>Please select a category</option>
                            @if (!empty($category))
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                            @endif

                        </select>
                        @error('category')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subCategoryName">Sub-category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="subCategoryName" placeholder="Enter sub-category name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="subCategorySlug">Sub-category Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="subCategorySlug" placeholder="Enter category slug" readonly>
                        @error('slug')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="subCategoryStatus">Status</label>
                        <select name="status" id="subCategoryStatus" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Block</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('sub-category.all')}}" class="btn btn-danger ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        
        $('body').on('change','#subCategoryName',function(){
            let element = $(this);
            $.ajax({
                url:"{{route('getSlug')}}",
                type:'get',
                data:{title: element.val()},
                dataType:'json',
                success: function(response){
                    if(response['status']==true){
                        $('#subCategorySlug').val(response['slug']);
                    }
                }

            })
        })
    </script>
@endsection
