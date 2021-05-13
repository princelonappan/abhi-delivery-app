@extends('admin.admin-template')

@section('content_header')
<h1>Manage Orders</h1>
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
        <div class="col-md-4 pull-right">
            <form action="">
                <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                    <option value="">Choose Status</option>
                    <option {{ !empty($status) && $status == 'Confirmed' ? 'selected' : '' }} value="Confirmed">Confirmed</option>
                    <option {{ !empty($status) && $status == 'Out for delivery' ? 'selected' : '' }} value="Out for delivery">Out for delivery</option>
                    <option {{ !empty($status) && $status == 'Delivered' ? 'selected' : '' }} value="Delivered">Delivered</option>
                    <option {{ !empty($status) && $status == 'Canceled' ? 'selected' : '' }} value="Canceled">Canceled</option>
                </select>
            </form>
        </div>
        <div class="card-tools">
            {{ $orders->links() }}
        </div>
    </div>
    <div class="card-header">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Order Id</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Order Total</th>
                        <th>Order Status</th>
                        <th>Created Date</th>
                        <th colspan=2>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1
                    @endphp
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->customer->user->email }}</td>
                        <td>{{ $order->order_total }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <form id="quickForm" action="{{ route('admin.order.update', $order->id) }}" novalidate="novalidate" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status">
                                    <option value="Confirmed" {{ $order->status == 'Confirmed' ? 'selected' : ''}}>Confirmed</option>
                                    <option value="Out for delivery" {{ $order->status == 'Out for delivery' ? 'selected' : ''}}>Out for delivery</option>
                                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                    <option value="Canceled" {{ $order->status == 'Canceled' ? 'selected' : ''}}>Canceled</option>
                                </select> &nbsp;&nbsp;
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.show',$order->id)}}">
                                <img src="{{url('/img/purchase-order.png')}}" title="View Order Details" style="width:50%;" />
                            </a>
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
