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
            <h3 class="card-title">Manage Delivery Charge</h3>
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
        <form id="quickForm" action="{{ route('admin.delivery_charge.store') }}" novalidate="novalidate" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Delivery Charge*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ !empty($delivery_charge->amount) ? $delivery_charge->amount : old('amount')}}" id="amount" name="amount" placeholder="Amount">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Min Amount*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="min_amount" value="{{ !empty($delivery_charge->min_amount) ? $delivery_charge->min_amount : old('min_amount')}}" name="min_amount" placeholder="Min Amount">
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
                amount: {
                    required: true,
                },
                min_amount: {
                    required: true,
                },
            },
            messages: {
                amount: {
                    required: "Please enter a amount",
                },
                min_amount: {
                    required: "Please enter min amount",
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
