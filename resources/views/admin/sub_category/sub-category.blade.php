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
                        <a href="" class="btn btn-warning">Edit</a>
                        <a href="#" onclick="" class="btn btn-danger">Delete</a>
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
@endsection