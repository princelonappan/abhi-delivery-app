@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ url('admin/css/admin.css') }}">
<style>

</style>

@endsection

@section('content')
     @yield('content')
@stop



@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script>
        $('.switch').on('change', '.checkbox', function() {
            $('.loading').show();
            var url = $(this).attr('data-href');
            var dataId = $(this).data('id');

            if($(this).is(":checked")) {
                var status = 1;
            }else {
                var status = 0;
            }
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    'status': status,
                    'dataId': dataId,
                }, //POST variable name value
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function () {
                    $('.loading').hide();
                }
            });
            //'unchecked' event code
        });

    </script>
@stop
