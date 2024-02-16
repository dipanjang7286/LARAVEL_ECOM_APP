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
        <form id="product_form" data-action="{{$url}}">
            @php
            $urlForCheck = url('').'/admin/product/store';
            // here checking the url is for adding category or updating category
            @endphp
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card">

                        <div class="card-body">

                            <div class="row justify-content-evenly">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="productTitle">Product Title</label>
                                        <input type="text" class="form-control" name="slug" id="productTitle"
                                            placeholder="Enter product slug" value="">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="productSlug">Product Slug</label>
                                        <input type="text" class="form-control" name="slug" id="productSlug"
                                            placeholder="Enter category slug" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Product Description</label>
                                <textarea id="summernote">

                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="productStatus">Product Status</label>
                                <select name="status" id="productStatus" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                            

                        </div>
                    </div>

                    <div class="row justify-content-evenly">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
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
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="subCategory">Select Sub Category</label>
                                        <select name="subCategory" id="subCategory" class="form-control">
                                            <option value="">Please select a sub-category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-evenly">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="brand">Select Brand</label>
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">Please select a brand</option>
                                            @if (!empty($brand))
                                            @foreach ($brand as $item)
                                            <option value="{{ $item->id }}">{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="featuredProduct">Featured Product</label>
                                        <select name="featuredProduct" id="featuredProduct" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Media</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <input type="hidden" name="image_id" id="image_id">
                                <label for="image">Product image</label>
                                <div class="dropzone dz-clickable form-control" id="image">
                                    <div class="dz-message needsClick">
                                        <br>Drop files here or click to upload <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-evenly">
                        <div class="col">
                            <div class="card">
    
                                <div class="card-header">
                                    <h4>Pricing</h4>
                                </div>
    
                                <div class="card-body">
    
                                    <div class="form-group">
                                        <label for="price">Product Price</label>
                                        <input type="number" class="form-control" name="price" id="price"
                                            placeholder="Enter product price" value="">
                                    </div>
    
                                    <div class="form-group">
                                        <label for="comAtprice">Compare at price</label>
                                        <input type="number" class="form-control mb-2 pb-2" name="comAtprice" id="comAtprice"
                                            placeholder="Enter compare at price" value="">
                                        <span>To show a reduced price, move the product’s original price into Compare at price. Enter a
                                            lower value into Product Price.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Inventory</h4>
                                </div>
                                <div class="card-body">
    
                                    <div class="form-group">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter product SKU"
                                            value="">
                                    </div>
    
                                    <div class="form-group">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" class="form-control" name="barcode" id="barcode"
                                            placeholder="Enter product barcode" value="">
                                    </div>
    
    
                                    <div class="form-group icheck-primary d-inline">
                                        <input type="checkbox" name="trackQuantity" id="trackQuantity" checked>
                                        <label for="trackQuantity">Track Quantity</label>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" id="quantity"
                                            placeholder="Enter product quantity" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('product.all')}}" class="btn btn-danger ml-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $('body').on('input','#productTitle',function(){
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
    });

    $('body').on('change',"#category", function(){
        let category_id = $(this).val();
        if(category_id !=''){

            $.ajax({
                url:"{{route('fetchSubCategoryByCategoryId')}}",
                type:'get',
                data:{category_id: category_id},
                dataType:'json',
                success: function(response){
                    $("#subCategory").find("option").not(':first').remove();
                    $.each(response.subCategory, function(key,item){
                        $("#subCategory").append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    
                }

            })

        }else{
            $("#subCategory").find("option").not(':first').remove();
            // console.log('No sub category found');
        }
    })

</script>
<script>
    $("#product_form").submit(function(e){
        e.preventDefault();
        let frmElement = $(this);
        let url = frmElement.attr('data-action');
        $.ajax({
            url: url,
            type: 'post',
            data:frmElement.serializeArray(),
            dataType: 'json',
            success: function(res){

            },
            error: function(err){
                console.log(err);
            }
        })
    })
</script>
@endsection