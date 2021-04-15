@extends('admin.admin-template')

@section('content')
<div class="col-md-12">
    <div class="card card-primary">

        <div class="col-sm-12">
            @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
        </div>

        <div class="card-header">
            <h3 class="card-title">List Product Images</h3>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif

        <style>
            * {
                box-sizing: border-box;
            }

            .imageColumn {
                float: left;
                width: 25%;
                padding: 18px;
            }

            h1 {
                text-align: center;
            }

            .rounded-0 {
                margin: 10px;
            }
        </style>
        <div class="alignRow">
            @foreach ($images as $image)
            <div class="imageColumn">
                <img src="{{$image->image_url}}" alt="Product Image" style="width:100%">
                <form action="{{ route('admin.products.image.destroy', ['product'=>$product_id,'image'=>$image->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" style="margin:10px;">Delete</button>
                            </form>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection

@section('js')
@stop