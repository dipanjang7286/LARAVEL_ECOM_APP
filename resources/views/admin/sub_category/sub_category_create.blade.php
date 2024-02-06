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
                    $category;
                @endphp
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="subCategoryName">Sub-category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="subCategoryName" placeholder="Enter sub-category name" value="{{ $url == $urlForCheck ? old('name') : $category->name}}">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="subCategorySlug">Sub-category Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="subCategorySlug" placeholder="Enter category slug" value="{{ $url == $urlForCheck ? old('slug') : $category->slug}}" readonly>
                        @error('slug')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="image_id" id="image_id">
                        <label for="image">Image</label>
                        <div class="dropzone dz-clickable form-control" id="image">
                            <div class="dz-message needsClick">
                                <br>Drop files here or click to upload <br><br>
                            </div>
                        </div>
                    </div>
                    @if (!empty($category->image))
                        <div class="form-group">
                            <label for="">Previous Image</label>
                            <div>
                                <img width="250" src="{{ asset('uploads/category/thumb/'.$category->image) }}" alt="">
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="subCategoryStatus">Status</label>
                        <select name="status" id="subCategoryStatus" class="form-control">
                            <option value="1" {{($url != $urlForCheck && $category->status == '1') ? 'selected' : ''}}>Active</option>
                            <option value="0" {{($url != $urlForCheck && $category->status == '0') ? 'selected' : ''}}>Block</option>
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
