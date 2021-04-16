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
            <h3 class="card-title">Add Branch</h3>
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
        <form id="quickForm" action="{{ route('admin.distributor.branch.store', $distributor_id) }}" novalidate="novalidate" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Branch Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="branch-name" name="branch_name"  placeholder="Name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number">
                    </div>
                </div>
                <div style="color:gray; margin: 10px;font-weight: bold;">Branch Address</div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address 1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address 2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">State</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="state" name="state" placeholder="State">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Zip</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country">
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
                branch_name: {
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
                address1: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                zip: {
                    required: true
                },
                country: {
                    required: true
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
                },
                address1: {
                    required: "Please enter a address",
                },
                city: {
                    required: "Please enter a city",
                },
                state: {
                    required: "Please enter a state",
                },
                zip: {
                    required: "Please enter a zip",
                },
                country: {
                    required: "Please enter a country",
                },
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