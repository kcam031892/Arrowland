@extends('layouts.backend.master')

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Range Rental</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Range Rental</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>

<div class="row">



    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card mb-3">
        <div class="card-header">
          <h3><i class="fa fa-table"></i> Range Rental {{ ucfirst($status) }} list</h3>
          @if(Session::has('flash_message_error'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
            </div>
          <div>

          @endif

          @if(Session::has('flash_message_success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
            </div>
          <div>

          @endif

        </div>

        <div class="card-body">
          <div class="table-responsive">
            @if($reservations->isEmpty())
              <h1 class="text-center">No Data Found!</h1>
            @else

              <table id="res_table" class="table table-bordered table-hover display">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer Name</th>
                  <th>Reservation Code</th>
                  <th>Reservation Date</th>
                  <th>Payment</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($reservations as $data)
                  @if($data['status'] == "Pending")

                    <tr id="{{$data->id}}">
                      <td>{{$data->id}}</td>
                      <td>{{$data->first_name . ' ' . $data->last_name }}</td>
                      <td>{{$data->reservation_code}}</td>
                      <td>{{ date('F d Y ',strtotime($data->reservation_date))}}</td>
                      <td>
                        @if(empty($data->paymentIsNotValid))
                        UNPAID
                        @else
                        PAID

                        @endif
                      </td>
                      <td>
                        @if($data->status == "Pending")
                          <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>
                          @if(!empty($data->paymentIsNotValid))
                          <!-- <a href="javascript:" rel="{{$data->id}}" class="btn btn-primary btn-sm accept">Check Payment</a> -->
                          <a href="{{ url('/admin/payment/'.$data->paymentIsNotValid->id.'/detail') }}" class="btn btn-primary btn-sm">Check Payment</a>
                          @endif

                          <a href="javascript:" data-id="{{$data->id}}" class="btn btn-danger btn-sm cancel">Cancel</a>

                        @elseif($data->status == "Accepted")
                          <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>
                          <a href="javascript:" data-id="{{$data->id}}" class="btn btn-primary btn-sm complete">Complete Reservation</a>
                          <a href="javascript:" data-id="{{$data->id}}" class="btn btn-danger btn-sm delete">Cancel</a>

                        @else
                          <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>
                        @endif
                      </td>
                    </tr>


                  @elseif($data['status'] == "Accepted")
                    @if($data['reservation_date'] <= date('m/d/Y'))
                      <tr id="{{$data->id}}">
                        <td>{{$data->id}}</td>
                        <td>{{$data->first_name . ' ' . $data->last_name }}</td>
                        <td>{{$data->reservation_code}}</td>
                        <td>{{ date('F d Y ',strtotime($data->reservation_date))}}</td>
                        <td>
                          @if(empty($data->paymentIsNotValid))
                          UNPAID
                          @else
                          PAID

                          @endif
                        </td>
                        <td>
                          <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>
                          <a href="javascript:" data-id="{{$data->id}}" class="btn btn-primary btn-sm complete">Complete Reservation</a>
                          <a href="javascript:" data-id="{{$data->id}}" class="btn btn-danger btn-sm delete">Cancel</a>
                        </td>
                      </tr>
                    @else
                    <tr id="{{$data->id}}">
                      <td>{{$data->id}}</td>
                      <td>{{$data->first_name . ' ' . $data->last_name }}</td>
                      <td>{{$data->reservation_code}}</td>
                      <td>{{ date('F d Y ',strtotime($data->reservation_date))}}</td>
                      <td>
                        @if(empty($data->paymentIsNotValid))
                        UNPAID
                        @else
                        PAID

                        @endif
                      </td>
                      <td>
                        <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>
                        <a href="javascript:" data-id="{{$data->id}}" class="btn btn-danger btn-sm delete">Cancel</a>
                      </td>
                    </tr>

                    @endif


                  @else
                  <tr id="{{$data->id}}">
                    <td>{{$data->id}}</td>
                    <td>{{$data->first_name . ' ' . $data->last_name }}</td>
                    <td>{{$data->reservation_code}}</td>
                    <td>{{ date('F d Y ',strtotime($data->reservation_date))}}</td>
                    <td>
                      @if(empty($data->paymentIsNotValid))
                      UNPAID
                      @else
                      PAID

                      @endif
                    </td>
                    <td>
                      <a href="{{ url('/admin/range-rental/'.$data->id.'/detail') }}" class="btn btn-success btn-sm">View</a>






                    </td>
                  </tr>



                  @endif


                @endforeach



              </tbody>
            </table>
            @endif
          </div>

        </div>
      </div><!-- end card-->
    </div>


</div>

@endsection



<!-- SCRIPT -->
@section('script')
<script type="text/javascript">

$(document).ready(function(){
  $('#res_table').DataTable({
    'order':[[2,'asc']]

  });

});

$(".delete").on('click',function(){
  var id = $(this).attr('rel');
  swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/range-rental/accept/"+id;
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

$(".accept").on('click',function(){

    var id = $(this).attr('rel');
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
      window.location.href="/admin/range-rental/accept/"+id;
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


$('.cancel').on('click',function(){
  var id = $(this).attr('data-id');
  swal({
  title: 'Are you sure you want to cancel this reservation?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Cancel it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/range-rental/cancel/"+id;

  }
})

});


$('.complete').on('click',function(){
  var id = $(this).attr('data-id');
  swal({
  title: 'Are you sure you want to complete this reservation?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Complete it!'
}).then((result) => {
  if (result.value) {
    window.location.href="/admin/range-rental/complete/"+id;

  }
})

});

//
// var dataTable = $('#table').DataTable();
//
// $.getJSON("{{ url('api/gallery/list') }}",function(data){
//   console.log(data.galleryList);
//
//   var tr = '';
//   $.each(data.galleryList, function(index,item){
//     dataTable.row.add([item.id,item.image_name,'<img src="{{asset("images/backend/gallery/small")}}'+item.image_url+'" style="height:100px;" />']).draw();
//   });
//
//
//
// });

</script>

@endsection
