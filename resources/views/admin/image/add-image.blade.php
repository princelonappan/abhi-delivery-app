@extends('admin.admin-template')

@section('content')
<div class="col-md-12">
  @include('admin.breadcumb')

  <div class="card card-primary">

    <div class="col-sm-12">
      @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}
      </div>
      @endif
    </div>

    <div class="card-header">
      <h3 class="card-title">Add Product Images</h3>
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
    <form method="POST" action="{{ route('admin.products.image.store', $product->id) }}" enctype="multipart/form-data">
      @csrf
      <div class="input-group file-div control-group lst increment" style="padding:10px;">
        <input type="file" name="files[]" class="myfrm form-control" style="padding: 3px;">
        <div class="input-group-btn">
          <button class="btn btn-success add-btn" type="button"><i class="fldemo fa fa-plus"></i></button>
        </div>
      </div>
      <div class="clone hide">
        <div class="file-div control-group lst input-group" style="margin-top:10px;padding:10px;">
          <input type="file" name="files[]" class="myfrm form-control" style="padding: 3px;">
          <div class="input-group-btn">
            <button class="btn btn-danger" type="button"><i class="fldemo fa fa-close"></i></button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center mt-4">
          <button type="submit" class="btn btn-success rounded-0">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".add-btn").click(function() {
      var lsthmtl = $(".clone").html();
      $(".increment").after(lsthmtl);
    });
    $("body").on("click", ".btn-danger", function() {
      $(this).parents(".file-div").remove();
    });
  });
</script>
@stop