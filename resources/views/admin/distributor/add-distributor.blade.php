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
            <h3 class="card-title">Add Distributor</h3>
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
        <form id="quickForm" action="{{ route('admin.distributor.store') }}" novalidate="novalidate" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{old('distributor_name')}}" id="distributor-name" name="distributor_name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" value="{{old('email')}}" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Phone number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone_number" value="{{old('phone_number')}}" name="phone_number" placeholder="Phone number">
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
                distributor_name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                    required: true,
                },
                phone_number: {
                    required: true,
                },
            },
            messages: {
                distributor_name: {
                    required: "Please enter a name",
                },
                email: {
                    required: "Please enter a email",
                },
                password: {
                    required: "Please enter a password",
                },
                phone_number: {
                    required: "Please enter a name",
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