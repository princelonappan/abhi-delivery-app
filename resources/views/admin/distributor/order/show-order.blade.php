@extends('admin.admin-template')

@section('content_header')
<h1>Manage Orders Details</h1>
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

<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <small class="float-right">Created Date: {{$order->created_at}}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{$order->distributor->name}}.</strong><br>
                {{$order->address->address	}}  {{$order->address->address2	? ', '.$order->address->address2	: $order->address->address2	}} <br>
                {{$order->address->city	}}, {{$order->address->state	}}, {{$order->address->country 	}} </br>
                {{$order->address->zip	}}
                Phone: {{$order->distributor->phone_number}}<br>
                Email: {{$order->distributor->user->email}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <br>
            <b>Order ID:</b> {{$order->No}}<br>
            <b>Product Total:</b> {{$order->product_total}}<br>
            <b>Vat Amount:</b> {{$order->vat}}<br>
            <b>Vat Percentage:</b> {{ number_format($order->vat_percentage,1) }}%<br>
            <b>Delivery Charge:</b> {{ $order->delivery_charge }}<br>
            <b>Palet Order Total:</b> {{$order->palet_order_total}}<br>
            <b>Order Status:</b> {{$order->status}}<br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Id</th>
                        <th style="width:35%">Product Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i = 1
                    @endphp
                    @foreach ($items as $item)
                    <tr>
                    @php
                $out = strlen($item->product->description) > 100 ? substr($item->product->description,0,100)." ..." : $item->product->description;
                @endphp
                        <td>{{ $i }}</td>
                        <td>{{ $item->product->title}}</td>
                        <td>{{ $item->product->id}}</td>
                        <td>{{ $out}}</td>
                        <td>{{ $item->qty}}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
            <!-- <p class="lead">Payment Methods:</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p> -->
        </div>
        <!-- /.col -->
        <div class="col-6">
            <!-- <p class="lead">Amount Due 2/22/2014</p> -->

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <!-- <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$250.30</td>
                        </tr>
                        <tr>
                            <th>Tax (9.3%)</th>
                            <td>$10.34</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>$5.80</td>
                        </tr> -->
                        <tr>
                            <th>Total:</th>
                            <td>{{$order->palet_order_total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <!-- <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
            </button>
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
            </button>
        </div> -->
    </div>
</div>

@endsection
