@extends('admin.admin-template')

@section('content_header')
<h1>Manage {{$distributor->name}}'s Branch</h1>
@stop

@section('content')
<div class="col-md-12">
    @include('admin.breadcumb')

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
</div>
<div class="card">
    <div class="card-header">
        <div>
            <a style="margin: 19px;" href="{{ route('admin.distributor.branch.create', $distributor_id)}}" class="btn btn-primary">New Branch</a>
        </div>
        <div class="card-tools">
            {{ $branch->links() }}
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
                @foreach ($branch as $_branch)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $_branch->branch_name }}</td>
                    <td>{{ $_branch->user->email }}</td>
                    <td>{{ $_branch->phone_number }}</td>
                    <td>{{ $_branch->status == 1 ? 'Active' : 'Inactive'  }}</td>
                    <td>{{ $_branch->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.distributor.branch.edit',  ['distributor' => $distributor_id, 'branch' => $_branch->id])}}">
                            <i class="nav-icon fas fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.distributor.branch.destroy', ['distributor' => $distributor_id, 'branch' => $_branch->id] )}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
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