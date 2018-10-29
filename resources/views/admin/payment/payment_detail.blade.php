@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Payment Detail</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Payment</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="card mb-3">
    <div class="card-header">
    <h3><i class="fa fa-hand-pointer-o"></i> Payment Detail</h3>

    </div>

    <div class="card-body">
      <div class="form-group">
        <label for="">Payment Method:</label>
        <span>{{$payment->payment_method}}</span>
      </div>
      <div class="form-group">
        @if($payment->payment_method == 'Smart Padala')
        <label for="">Contact Number:</label>
        @else
        <label for="">Sender Name:</label>

        @endif

        <span>{{$payment->sender_name}}</span>
      </div>
      <div class="form-group">
        <label for="">Reference Number:</label>
        <span>{{$payment->transaction_code}}</span>
      </div>
      <div class="form-group">
        <label for="">Amount:</label>
        <span>&#8369;{{$payment->amount_pay}}</span>
      </div>
      <div class="form-group">
        <a href="javascript::" data-id="{{$payment->reservation->id}}" data-payment-id="{{$payment->id}}" class="btn btn-primary accept">Accept Reservation</a>
        <a href="javascript::" data-id="{{$payment->id}}" class="btn btn-danger deletePayment">Payment not valid</a>
        <a href="javascript::" data-id="{{$payment->reservation->id}}" class="btn btn-success cancel">Cancel</a>



      </div>


    </div>
    </div><!-- end card-->
  </div>

  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="card mb-3">
    <div class="card-header">
    <h3><i class="fa fa-hand-pointer-o"></i> Image</h3>

    </div>

    <div class="card-body">


      <div class="form-group">
        <a data-fancybox="single" href="{{ asset('images/backend/receipt/'.$payment->image_path)}}" class="col-sm-2">
          <img alt="image"  src="{{ asset('images/backend/receipt/'.$payment->image_path)}}" class="img-fluid" style="height:400px;">
        </a>

      </div>



      <!-- <form action="{{ url('api/account/register')}}" data-parsley-validate novalidate method="post" enctype="multipart/form-data">
        {{csrf_field()}}
                                      <div class="form-group">
                                          <label for="userName">Title<span class="text-danger">*</span></label>
                                          <input type="text" name="title" data-parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="userName">
                                      </div>

                                      <div class="form-group">
                                        <input type="file" name="file">

                                      </div>

                                      <div class="form-group text-right m-b-0">
                                          <button class="btn btn-primary" type="submit">
                                              Submit
                                          </button>
                                          <button type="reset" class="btn btn-secondary m-l-5">
                                              Cancel
                                          </button>
                                      </div>

                          </form> -->

    </div>
    </div><!-- end card-->
  </div>


</div>



@endsection

@section('script')

<script type="text/javascript">

$('.accept').on('click',function(){
  var id = $(this).attr('data-id');
  var payment_id = $(this).attr('data-payment-id');
  swal({
  title: 'Are you sure you want to accept this reservation?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Accept it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/range-rental/accept/"+id+"/"+payment_id;

  }
})

});

$('.cancel').on('click',function(){
  var id = $(this).attr('data-id');
  swal({
  title: 'Are you sure you want to cancel this reservation',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Cancel it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/range-rental/cancel/"+id;
    // swal(
    //   'Deleted',
    //   'Your image has been deleted!',
    //   'success'
    // )

    // $.getJSON("{{url('/admin/gallery/delete/')}}")

    // $("#example1 tr#"+id+"").remove();

  }
})

});


$('.deletePayment').on('click',function(){
  var id = $(this).attr('data-id');
  swal({
  title: 'Are you sure you want to cancel this payment?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Cancel it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/payment/delete/"+id;
    // swal(
    //   'Deleted',
    //   'Your image has been deleted!',
    //   'success'
    // )

    // $.getJSON("{{url('/admin/gallery/delete/')}}")

    // $("#example1 tr#"+id+"").remove();

  }
})

});



</script>

@endsection
