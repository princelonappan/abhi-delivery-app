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
            <h3 class="card-title">Edit Godown</h3>
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
        <form id="quickForm" action="{{ route('admin.godown.update', $godown->id) }}" novalidate="novalidate" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="godown-name" value="{{$godown->name}}" name="godown_name" placeholder="Godown Name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Godown Id</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="godown-id" value="{{$godown->godown_unique_id}}" name="godown_id" placeholder="Godown Id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Details</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="details" value="{{$godown->details}}" name="details" placeholder="Details">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" value="{{$godown->address}}" name="address" placeholder="Address">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Latitude</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="latitude" value="{{$godown->latitude}}" name="latitude" placeholder="Latitude">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Longitude</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="longitude" value="{{$godown->longitude}}" name="longitude" placeholder="Longitude">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Zip code</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" id="zip" name="zip" placeholder="Zip code (Comma separated)">{{$godown_zip}}</textarea>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
                godown_name: {
                    required: true,
                },
                godown_id: {
                    required: true,
                },
                details: {
                    required: true,
                },
                latitude: {
                    required: true,
                },
                longitude: {
                    required: true,
                },
                zip: {
                    required: true,
                },
                address: {
                    required: true,
                },
            },
            messages: {
                godown_name: {
                    required: "Please enter a name",
                },
                godown_id: {
                    required: "Please enter a godown id",
                },
                details: {
                    required: "Please enter a details",
                },
                latitude: {
                    required: "Please enter a latitude",
                },
                longitude: {
                    required: "Please enter a longitude",
                },
                zip: {
                    required: "Please enter a zip",
                },
                address: {
                    required: "Please enter a Address",
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
    });
</script>
@stop