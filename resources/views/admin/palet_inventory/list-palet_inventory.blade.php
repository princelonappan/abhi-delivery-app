@extends('admin.admin-template')

@section('content_header')
<h1>Manage Palet Inventory</h1>
@stop

@section('content')
<div class="col-md-12">
    @include('admin.breadcumb')

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
</div>
<div class="card">
    <div class="card-header">
        <div>
            <a style="margin: 19px;" href="{{ route('admin.palet-inventory.download-sample-csv')}}" class="btn btn-primary">Download Sample CSV file </a>

            <div style="float:right;">
                <form enctype='multipart/form-data' action="{{ route('admin.palet-inventory.store') }}" method='POST'>
                @csrf
                <label>Upload Product CSV file Here</label>
                    <input size='50' type='file' name='csv_import'>
                    </br>
                    <input type='submit' class="btn btn-primary" name='submit' value='Upload CSV'>
                </form>
            </div>
            <div class="col-md-4 pull-right">
                <form action="">
                    <select class="form-control" name="godown_unique_id" id="godown_unique_id" onchange="this.form.submit()">
                        <option value="">Choose Godown</option>
                        @foreach($godowns as $godown)
                        <option {{ !empty($godown_unique_id) && $godown_unique_id ==  $godown->godown_unique_id ? 'selected' : '' }} value="{{ $godown->godown_unique_id }}">{{ $godown->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-tools">
                {{ $palet_inventory->links() }}
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
                    <th>Product Name</th>
                    <th>Product Id</th>
                    <th>Palet Id</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1
                @endphp
                @if(!$palet_inventory->isEmpty())
                @foreach ($palet_inventory as $_palet)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $_palet->godown->name }}</td>
                    <td>{{ $_palet->godown_id }}</td>
                    <td>{{ $_palet->product->title }}</td>
                    <td>{{ $_palet->product_id }}</td>
                    <td>{{ $_palet->palet_id }}</td>
                    @php
                        if($_palet->available == 1) {
                            $status = 'Available';
                        } else {
                            $status = 'Unavailable';
                        }
                    @endphp
                    <td>{{ $status  }}</td>
                    <td>{{ $_palet->created_at }}</td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach
                @else
                <tr>
                    <td colspan="8">No record found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
</div>

@endsection
