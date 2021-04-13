@extends('admin.admin-template')

@section('content_header')
<h1>Manage Distributor</h1>
@stop

@section('content')
<div class="col-md-12">

@if(session()->get('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
</div>
    <div class="card">
        <div class="card-header">
            <div>
                <a style="margin: 19px;" href="{{ route('admin.distributor.create')}}" class="btn btn-primary">New Distributor</a>
            </div>
            <div class="card-tools">
                {{ $distributor->links() }}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th colspan=2>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1
                    @endphp
                    @foreach ($distributor as $_distributor)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $_distributor->name }}</td>
                        <td>{{ $_distributor->email }}</td>
                        <td>{{ $_distributor->phone_number }}</td>
                        <td>{{ $_distributor->status == 1 ? 'Active' : 'Inactive'  }}</td>
                        <td>{{ $_distributor->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.distributor.edit',$_distributor->id)}}">
                                <i class="nav-icon fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.distributor.destroy', $_distributor->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                        <td>
                            <a href="" class="btn btn-danger" style="background-color:green; border-color:green;" >Manage Branches </a>
                        </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@endsection