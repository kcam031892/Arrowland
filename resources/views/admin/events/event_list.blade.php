@extends('layouts.backend.master')

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Upcoming Events</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Upcoming Event</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>

<div class="row">



    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card mb-3">
        <div class="card-header">
          <h3><i class="fa fa-table"></i> Events List</h3>
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

              <table id="example1" class="table table-bordered table-hover display">
                <thead>
                  <tr>
                    <th>No</th>
                    <td>ID</td>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($json) && !empty($firebaseId))
                    @foreach($json as $key => $data)
                      <tr id="{{$data['id']}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$key}}</td>
                        <td>{{$data['title']}}</td>
                        <td>{{$data['message']}}</td>
                        <td><img src="{{$data['image_url']}}" height="100"/></td>
                        <td><a href="{{ url('/admin/events/delete/'.$key)}}" class="btn btn-danger">Delete</a></td>
                      </tr>

                    @endforeach
                  @endif



                </tbody>
              </table>


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
    window.location.href="/admin/gallery/delete/"+id;
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
