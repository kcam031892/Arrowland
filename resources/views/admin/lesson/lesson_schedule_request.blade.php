@extends('layouts.backend.master')

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Lesson</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Lesson</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>

<div class="row">



    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card mb-3">
        <div class="card-header">
          <h3><i class="fa fa-table"></i> Lesson Enrolled List</h3>
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
            @if($lesson_session->isEmpty())
              <h1 class="text-center">No Data Found!</h1>
            @else
              <table id="example1" class="table table-bordered table-hover display">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lesson_session as $data)
                <tr id="{{$data->id}}">
                  <td>{{$data->id}}</td>
                  <td>{{$data->first_name . ' ' . $data->last_name }}</td>
                  <td>{{ date('F d Y ',strtotime($data->session_date))}}</td>
                  <td>{{$data->session_time}}</td>

                  <td>

                    <a href="javascript:" rel="{{$data->id}}" class="btn btn-primary btn-sm accept">Accept</a>
                    <a href="javascript:" rel="{{$data->id}}" class="btn btn-danger btn-sm delete">Cancel</a>



                  </td>
                </tr>

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
      window.location.href="/admin/lesson/schedule-request/accept/"+id;
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
