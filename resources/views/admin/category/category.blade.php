@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    {{-- showing session messages here --}}
    @include('admin.message')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All Category</h1>
            </div>
            <div class="col-sm-6">
                <ul class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('category.create')}}" class="btn btn-primary">Add Category</a>
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

        <table id="category-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($category as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->slug}}</td>
                    <td class="align-middle text-center">
                        @if ($value->status == 1)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <!-- Success Tick Mark -->
                                <circle cx="12" cy="12" r="11" fill="none" stroke="#63E6BE" stroke-width="2"/>
                                <path d="M7 13l3 3 7-7" stroke="#63E6BE" stroke-width="2" fill="none" />
                            </svg>
                        @else
                        
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <!-- Cross -->
                                <circle cx="12" cy="12" r="11" fill="none" stroke="#FF6B6B" stroke-width="2"/>
                                <path d="M12 10.586l4.95-4.95c.39-.39 1.024-.39 1.414 0s.39 1.024 0 1.414L13.414 12l4.95 4.95c.39.39.39 1.024 0 1.414s-1.024.39-1.414 0L12 13.414l-4.95 4.95c-.39.39-1.024.39-1.414 0s-.39-1.024 0-1.414L10.586 12 5.636 7.05c-.39-.39-.39-1.024 0-1.414s1.024-.39 1.414 0L12 10.586z" fill="#FF6B6B"/>
                            </svg>
                        @endif
                        
                    </td>
                    <td>
                        <a href="{{route('category.edit', ['id'=>$value->id])}}" class="btn btn-warning">Edit</a>
                        <a href="#" onclick="deleteCategory({{ $value->id }})" class="btn btn-danger">Delete</a>
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
    $('#category-table').DataTable({
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
    function deleteCategory(id){
        // console.log(id);
        var url = "{{ route('category.delete', 'ID') }}";
        var newUrl = url.replace("ID", id);
        // alert(newUrl);
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this category!",
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
                            window.location.href="{{ route('category.all') }}";
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