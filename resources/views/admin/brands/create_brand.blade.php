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
                            <a href="{{route('brand.all')}}" class="btn btn-primary">Back</a>
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
            <form id="brand-form" name="brand-form" data-action="{{$url}}">
                @php
                    $urlForCheck = url('').'/admin/brand/store';
                    // here checking the url is for adding category or updating category
                @endphp
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="brandName">Brand Name</label>
                        <input type="text" class="form-control" name="name" id="brandName" placeholder="Enter brand name" value="{{ $url == $urlForCheck ? old('name') : $brand->name}}">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <label for="brandSlug">Brand Slug</label>
                        <input type="text" class="form-control" name="slug" id="brandSlug" placeholder="Enter brand slug" value="{{ $url == $urlForCheck ? old('slug') : $brand->slug}}" readonly>
                        <p></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="brandStatus">Status</label>
                        <select name="status" id="brandStatus" class="form-control">
                            <option value="1" {{ ($url != $urlForCheck && $brand->status == '1') ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ ($url != $urlForCheck && $brand->status == '0') ? 'selected' : '' }}>Block</option>
                        </select>
                        <p></p>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('brand.all')}}" class="btn btn-danger ml-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('#brand-form').submit(function(e){
            e.preventDefault();
            let frmElement = $(this);
            let url = frmElement.attr('data-action');
            // console.log(url);
            $('button[type=submit]').prop('disabled',true); // once you press submit then after the success response the button will eneble
            $.ajax({
                url:url,
                type:'post',
                data: frmElement.serializeArray(),
                dataType:'json',
                success: function(res){
                    $('button[type=submit]').prop('disabled',false);
                    if(res.success==true){
                        window.location.href = `{{route('brand.all')}}`;
                    }else{
                        let errors = res.message;
                        // console.log(errors);
                        if(errors.name){
                            $('#brandName').addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(`${errors.name}`);
                        }else{
                            $('#brandName').removeClass("is-imvalid").siblings('p').removeClass('invalid-feedback').html("");
                        }

                        if(errors.slug){
                            $('#brandSlug').addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(`${errors.slug}`);
                        }else{
                            $('#brandSlug').removeClass("is-imvalid").siblings('p').removeClass('invalid-feedback').html("");
                        }
                    }
                    
                }
            })
        })
    </script>
    <script>
        $('body').on('input','#brandName',function(){
            let element = $(this);
            $.ajax({
                url:"{{route('getSlug')}}",
                type:'get',
                data:{title: element.val()},
                dataType:'json',
                success: function(response){
                    if(response.status==true){
                        $('#brandSlug').val(response['slug']);
                    }
                }

            })
        })
    </script>
@endsection
