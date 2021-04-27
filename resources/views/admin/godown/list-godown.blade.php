@extends('admin.admin-template')

@section('content_header')
<h1>Manage Godown</h1>
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
            <a style="margin: 19px;" href="{{ route('admin.godown.create')}}" class="btn btn-primary">New Godown</a>
        </div>
        <div class="card-tools">
            {{ $godown->links() }}
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Godown name</th>
                    <th>Godown id</th>
                    <th>Details</th>
                    <th>Address</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th colspan=2>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1
                @endphp
                @foreach ($godown as $_godown)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $_godown->name }}</td>
                    <td>{{ $_godown->godown_unique_id }}</td>
                    <td>{{ $_godown->details }}</td>
                    <td>{{ $_godown->address }}</td>
                    <td>{{ $_godown->latitude	 }}</td>
                    <td>{{ $_godown->longitude	 }}</td>
                    @php
                        if($_godown->status == 1) {
                            $statusUpdate = 'Inactivate';
                            $status = 'Active';
                            $class = 'btn-danger';
                        } else {
                            $statusUpdate = 'Activate';
                            $status = 'Inactive';
                            $class = 'btn-success';
                        }
                    @endphp
                    <td>{{ $status  }}</td>
                    <td>{{ $_godown->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.godown.edit',$_godown->id)}}">
                            <i class="nav-icon fas fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.godown.destroy', $_godown->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn {{$class}}" type="submit">{{$statusUpdate}}</button>
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