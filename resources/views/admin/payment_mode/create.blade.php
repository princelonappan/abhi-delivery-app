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
            <h3 class="card-title">Manage Payment Mode</h3>
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
        <form id="quickForm" action="{{ route('admin.payment_mode.store') }}" novalidate="novalidate" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Cash on Delivery</label>
                    <div class="col-sm-10">
                        <input id="cash_on_delivery" type="checkbox" style="width:20px; height:30px;" name="cash_on_delivery" value="1" {{ !empty($payment_mode) && $payment_mode->cash_on_delivery == 1 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Card Payment</label>
                    <div class="col-sm-10">
                        <input id="card_payment" type="checkbox" style="width:20px; height:30px;" name="card_payment" value="1"  {{ !empty($payment_mode) && $payment_mode->card_payment == 1 ? 'checked' : '' }}>
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
                }
            },
            messages: {
                amount: {
                    required: "Please enter a amount",
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
