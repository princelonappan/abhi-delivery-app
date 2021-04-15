@extends('admin.admin-template')

@section('content_header')
<h1>Manage Products</h1>
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
                <a style="margin: 19px;" href="{{ route('admin.products.create')}}" class="btn btn-primary">New Product</a>
            </div>
            <div class="card-tools">
                {{ $products->links() }}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Product Title</th>
                        <th>Description</th>
                        <th>Price Per Unit</th>
                        <th>Price Per Palet</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Created Date</th>
                        <th colspan=2>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1
                    @endphp
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price_per_unit }}</td>
                        <td>{{ $product->price_per_palet }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>{{ $product->categories->category_name }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit',$product->id)}}" title="Edit">
                                <i class="nav-icon fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.destroy', $product    ->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.image.create',$product->id)}}" class="btn btn-danger" style="background-color:green; border-color:green;" >Add Images </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.image.index',$product->id)}}" class="btn btn-danger" style="background-color:green; border-color:green;" >Show Images </a>
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