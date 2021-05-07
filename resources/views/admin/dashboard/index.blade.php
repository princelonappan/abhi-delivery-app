@extends('admin.admin-template')

@section('content_header')

@stop

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $customers }}</h3>

                <p>Total Customer</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              {{--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>  --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $distributors }}</h3>

                <p>distributors</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              {{--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>  --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $orders }}</h3>

                <p>Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              {{--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>  --}}
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $products }}</h3>

                <p>Active Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              {{--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>  --}}
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection


