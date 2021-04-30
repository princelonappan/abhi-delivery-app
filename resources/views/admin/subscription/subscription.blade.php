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
            <h3 class="card-title">Manage Subscription</h3>
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
        <form id="quickForm" action="{{ route('admin.subscription.store') }}" novalidate="novalidate" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Subscription Amount*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ !empty($subscription->subscription_amount) ? $subscription->subscription_amount : old('subscription_amount')}}" id="subscription-amount" name="subscription_amount" placeholder="Subscription Amount">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Number of Days*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_days" value="{{ !empty($subscription->no_days) ? $subscription->no_days : old('no_days')}}" name="no_days" placeholder="No Days">
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
                subscription_amount: {
                    required: true,
                },
                no_days: {
                    required: true,
                },
            },
            messages: {
                distributor_name: {
                    required: "Please enter a amount",
                },
                email: {
                    required: "Please enter a days",
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
