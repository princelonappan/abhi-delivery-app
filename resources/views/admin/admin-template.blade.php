@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')
     @yield('content')  
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop