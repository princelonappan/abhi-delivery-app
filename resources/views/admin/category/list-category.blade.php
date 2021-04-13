@extends('admin.admin-template')

@section('content_header')
<h1>Manage Category</h1>
@stop

@section('content')
<div class="col-md-12">

@if(session()->get('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
</div>
    <div class="card">
        <div class="card-header">
            <div>
                <a style="margin: 19px;" href="{{ route('admin.category.create')}}" class="btn btn-primary">New Category</a>
            </div>
            <div class="card-tools">
                {{ $categories->links() }}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th colspan=2>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1
                    @endphp
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->status == 1 ? 'Active' : 'Inactive'  }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit',$category->id)}}">
                                <i class="nav-icon fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.category.destroy', $category->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@endsection