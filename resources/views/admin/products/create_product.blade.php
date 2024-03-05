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
                                        <label for="title">Product Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter product title" value="{{ $url == $urlForCheck ? old('title') : $product->title}}">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="slug">Product Slug</label>
                                        <input type="text" class="form-control" name="slug" id="slug"
                                            placeholder="Enter product slug" value="{{ $url == $urlForCheck ? old('slug') : $product->slug}}" readonly>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="summernote">Product Description</label>
                                <textarea id="summernote" name="description">
                                    {{ $url == $urlForCheck ? old('description') : $product->description}}
                                </textarea>
                                <p class="error"></p>
                            </div>

                            <div class="form-group">
                                <label for="productStatus">Product Status</label>
                                <select name="status" id="productStatus" class="form-control">
                                    <option value="1" {{ ($url != $urlForCheck && $product->status == '1') ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($url != $urlForCheck && $product->status == '0') ? 'selected' : '' }}>Block</option>
                                </select>
                                <p class="error"></p>
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
                                            <option value="{{ $item->id }}" {{ ($url != $urlForCheck && $product->category_id == $item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="subCategory">Select Sub Category</label>
                                        @if ($url != $urlForCheck)
                                            <input type="hidden" id="subCategoryIdForselect" value="{{$product->sub_category_id}}">
                                        @endif
                                        <select name="subCategory" id="subCategory" class="form-control">
                                            <option value="">Please select a sub-category</option>
                                        </select>
                                        <p class="error"></p>
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
                                            <option value="{{ $item->id }}" {{ ($url != $urlForCheck && $product->brand_id == $item->id) ? 'selected' : '' }}>{{$item->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <p class="error"></p>
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
                                            <option value="Yes" {{ ($url != $urlForCheck && $product->is_featured == 'Yes') ? 'selected' : '' }}>Yes</option>
                                            <option value="No" selected>No</option>
                                        </select>
                                        <p class="error"></p>
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
                                <label for="image">Product image</label>
                                <div class="dropzone dz-clickable form-control" id="image">
                                    <div class="dz-message needsClick">
                                        <br>Drop files here or click to upload <br><br>
                                    </div>
                                </div>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="product-galary">
                        @if ($url != $urlForCheck)
                            @foreach ($productImages as $image)
                                <div class="col-md-3" id="image-row-{{$image->id}}">
                                    <div class="card">
                                        <input type="hidden" name="image_array[]" value="{{$image->id}}">
                                        <img src="{{asset('uploads/product/small/'.$image->image)}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" onclick="deleteImageFromCard({{$image->id}})" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
                                            placeholder="Enter product price" value="{{ $url == $urlForCheck ? old('price') : $product->price}}">
                                        <p class="error"></p>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="comAtprice">Compare at price</label>
                                        <input type="number" class="form-control mb-2 pb-2" name="comAtprice" id="comAtprice"
                                            placeholder="Enter compare at price" value="{{ $url == $urlForCheck ? old('comAtprice') : $product->compare_price}}">
                                        <p class="error"></p>
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
                                            value="{{ $url == $urlForCheck ? old('sku') : $product->sku}}">
                                        <p class="error"></p>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" class="form-control" name="barcode" id="barcode"
                                            placeholder="Enter product barcode" value="{{ $url == $urlForCheck ? old('barcode') : $product->barcode}}">
                                        <p class="error"></p>
                                    </div>
    
    
                                    <div class="form-group icheck-primary d-inline">
                                        <input type="hidden" name="trackQuantity" id="trackQuantity" value="{{ $url == $urlForCheck ? 'Yes' : $product->track_quantity}}">
                                        <input type="checkbox" id="trackQuantity_checkbox" checked>
                                        <label for="trackQuantity_checkbox" class="ml-2">Track Quantity</label>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" id="quantity"
                                            placeholder="Enter product quantity" value="{{ $url == $urlForCheck ? old('quantity') : $product->quantity}}">
                                        <p class="error"></p>
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
    $(document).ready(function() {
        $('#trackQuantity_checkbox').change(function() {
            if ($(this).is(':checked')) {
                $("#trackQuantity").val('Yes');
            } else {
                $("#trackQuantity").val('No');
            }
        });

        if($("#trackQuantity").val() == 'Yes'){
            $('#trackQuantity_checkbox').prop('checked', true);
        }else{
            $('#trackQuantity_checkbox').prop('checked', false);
        }

        if ("{{ $url }}" !== "{{ $urlForCheck }}") {
            // After populating the options dynamically, trigger the change event
            $("#category").trigger('change');
        }
    });

    Dropzone.autoDiscover = false;
    const dropzone = $('#image').dropzone({
        url: "{{route('temp-image.create')}}", // post route for image upload for category
        maxFiles: 10,
        paramName: 'image', // by default paramName : 'file'. I change it to 'image'.
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/jpg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, res){
            let html = `
            <div class="col-md-3" id="image-row-${res.image_id}">
                <div class="card">
                    <input type="hidden" name="image_array[]" value="${res.image_id}">
                    <img src="${res.imagePath}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImageFromCard(${res.image_id})" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>`;
            $("#product-galary").append(html);
        },
        complete: function(file){
            this.removeFile(file);
        }
    })
    function deleteImageFromCard(id){
        $(`#image-row-${id}`).remove();
    }
</script>
<script>
    $('body').on('input','#title',function(){
        let element = $(this);
        $.ajax({
            url:"{{route('getSlug')}}",
            type:'get',
            data:{title: element.val()},
            dataType:'json',
            success: function(response){
                if(response['status']==true){
                    $('#slug').val(response['slug']);
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
                        let subCategoryIdForselect = $("#subCategoryIdForselect").val();
                        let selected = '';
                        if((typeof subCategoryIdForselect !== 'undefined') && (subCategoryIdForselect == item.id )){
                            selected = 'selected';
                        }
                        $("#subCategory").append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
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
        $('button[type=submit]').prop('disabled',true);
        $.ajax({
            url: url,
            type: 'post',
            data:frmElement.serializeArray(),
            dataType: 'json',
            success: function(res){
                $('button[type=submit]').prop('disabled',false);
                if(res.success==true){
                        window.location.href = `{{route('product.all')}}`;
                }else{
                    let errors = res.message;
                    // console.log(errors);
                    $(".error").removeClass('invalid-feedback').html('');
                    $(`input[type='text'], input[type=number], select`).removeClass('is-invalid');
                    $.each(errors, function(key, value){
                        $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                    });

                }
            },
            error: function(err){
                console.log(err);
            }
        })
    })
</script>
@endsection