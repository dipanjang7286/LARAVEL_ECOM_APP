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
                            <a href="{{route('category.all')}}" class="btn btn-primary">Back</a>
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
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="categoryName" placeholder="Enter category name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="categorySlug">Category Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="categorySlug" placeholder="Enter category slug" readonly>
                        @error('slug')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="dropzone dz-clickable" id="image">
                            <div class="dz-message needsClick">
                                <br>Drop files here or click to upload <br><br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="categoryStatus">Status</label>
                        <select name="status" id="categoryStatus" class="form-control">
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
                    <a href="{{route('category.all')}}" class="btn btn-danger ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        
        $('body').on('change','#categoryName',function(){
            let element = $(this);
            $.ajax({
                url:"{{route('getSlug')}}",
                type:'get',
                data:{title: element.val()},
                dataType:'json',
                success: function(response){
                    if(response['status']==true){
                        $('#categorySlug').val(response['slug']);
                    }
                }

            })
        })

    </script>
@endsection
