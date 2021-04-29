@extends('admin.admin-template')

@section('content')
<div class="col-md-12">
    <div class="card card-primary">

        <div class="col-sm-12">
            @include('admin.breadcumb')

            @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
        </div>

        <div class="card-header">
            <h3 class="card-title">Edit Product</h3>
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
        <form id="quickForm" action="{{ route('admin.products.update', $product->id) }}" novalidate="novalidate" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Product Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_title" value="{{ $product->title }}" name="product_title" placeholder="Product title">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description" value="" placeholder="Product Description">{{ $product->description }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Price Per Unit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price_per_unit" value="{{ $product->price_per_unit }}" name="price_per_unit" placeholder="Price Per Unit">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Price Per Palet</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price_per_palet" value="{{ $product->price_per_palet }}" name="price_per_palet" placeholder="Price Per Palet">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Unit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="unit" name="unit" value="{{ $product->unit }}" placeholder="Units of Measurement">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quantity" value="{{ $product->qty }}" name="quantity" placeholder="Quantity">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Is special product?</label>
                    <div class="col-sm-10">
                        <input id="speical_product" type="checkbox" style="width:20px; height:30px;" name="speical_product" value="1" {{ $product->is_special_product == 1 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Is featured?</label>
                    <div class="col-sm-10">
                        <input id="is_featured" type="checkbox" style="width:20px; height:30px;" name="is_featured" value="1" {{ $product->is_featured == 1 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="category" name="category">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ( $category->id == $product->category_id) ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function() {
        $('#quickForm').validate({
            rules: {
                product_title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                price_per_unit: {
                    required: true,
                    number: true
                },
                price_per_palet: {
                    required: true,
                    number: true
                },
                unit: {
                    required: true,
                },
                quantity: {
                    required: true,

                },
                category: {
                    required: true
                }
            },
            messages: {
                product_title: {
                    required: "Please enter a product title",
                },
                description: {
                    required: "Please enter a product description",
                },
                price_per_unit: {
                    required: "Please enter a price for a unit",
                },
                price_per_palet: {
                    required: "Please enter a price for a palet",
                },
                unit: {
                    required: "Please enter a unit",
                },
                quantity: {
                    required: "Please enter a quantity",
                },
                category: {
                    required: "Please select a category",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#is_featured').change(function() {
            if(this.checked) {
                $(this).prop("checked", true);
                $('#speical_product').prop("checked", false);
            }
        });

        $('#speical_product').change(function() {
            if(this.checked) {
                $(this).prop("checked", true);
                $('#is_featured').prop("checked", false);
            }
        });
    });
</script>
@stop
