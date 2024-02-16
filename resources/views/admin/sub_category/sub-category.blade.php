@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    {{-- showing session messages here --}}
    @include('admin.message')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All sub category</h1>
            </div>
            <div class="col-sm-6">
                <ul class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('sub-category.create')}}" class="btn btn-primary">Add sub category</a>
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

        <table id="sub-category-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Sub-Category Name</th>
                    <th>Sub-Category Slug</th>
                    <th>Sub-Category Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($subCategory as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->category_name}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->slug}}</td>
                    <td>
                        @if ($value->status == 1)
                            {{"Active"}}
                        @else
                            {{"In-Active"}}
                        @endif
                        
                    </td>
                    <td>
                        <a href="{{ route('sub-category.edit', ['id'=>$value->id]) }}" class="btn btn-warning">Edit</a>
                        <a href="#" onclick="deleteSubCategory({{$value->id}})" class="btn btn-danger">Delete</a>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $('#sub-category-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
    
</script>

<script>
    function deleteSubCategory(id){
        // console.log(id);
        var url = "{{ route('sub-category.delete', 'ID') }}";
        var newUrl = url.replace("ID", id);
        // alert(newUrl);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this sub-category!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes !"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: newUrl,
                    type:'POST',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res){

                        if(res.status==true){
                            window.location.href="{{ route('sub-category.all') }}";
                        }else{
                            window.location.reload();
                        }
                    }
                });
            }
        });  
    }
</script>
@endsection