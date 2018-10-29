@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">Renge Rental Detail</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Range Rental</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="card mb-3">
    <div class="card-header">
    <h3><i class="fa fa-hand-pointer-o"></i> Reservation Detail</h3>

    </div>

    <div class="card-body">
      <div class="form-group">
        <label for="">Reservation Code:</label>
        <span>{{$reservations->reservation_code}}</span>
      </div>
      <div class="form-group">
        <label for="">Reservation Date:</label>
        <span>{{date('F d D',strtotime($reservations->reservation_date))}}</span>
      </div>
      <div class="form-group">
        <label for="">Reservation Time:</label>
        <span>{{$reservations->reservation_time}}</span>
      </div>

      <div class="form-group">
        <label for="">Package</label>
        @php
        $package = array("25 Arrows","50 Arrows","75 Arrows","120 Arrows","150 Arrows","200 Arrows","240 Arrows","300 Arrows");

        @endphp
        <span>{{$package[$reservations->package - 1]}}</span>
      </div>
      <div class="form-group">
        <label for="">Coaches:</label>
        <span>{{$reservations->with_coaches}}</span>
      </div>
      <div class="form-group">
        <label for="">With Member:</label>
        <span>{{$reservations->member_status}}</span>

      </div>

      <div class="form-group">
        <label for="">Total:</label>
        @if($reservations->member_status == "Member")
          <span>&#8369;{{number_format($reservations->total - $reservations->total * .10,2)}}</span>

        @else
          <span>&#8369;{{number_format($reservations->total,2)}}</span>
        @endif

      </div>

      <div class="form-group">
        <label for="">Status:</label>
        @if($reservations->res_status == "Pending")
          <span class="text-primary">{{$reservations->res_status}}</span>

        @elseif($reservations->res_status == "Accepted")
          <span class="text-success">{{$reservations->res_status}}</span>

        @else
        <span class="text-danger">{{$reservations->res_status}}</span>






        @endif

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

  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="card mb-3">
    <div class="card-header">
    <h3><i class="fa fa-hand-pointer-o"></i> Customer Detail</h3>
    </div>

    <div class="card-body">
      <div class="form-group">
        <label for="">Name:</label>
        <span>{{$reservations->first_name .' '. $reservations->last_name}}</span>

      </div>

      <div class="form-group">
        <label for="">Email:</label>
        <span>{{$reservations->email}}</span>

      </div>

      <div class="form-group">
        <label for="">Contact Number:</label>
        <span>{{$reservations->contact_number}}</span>

      </div>



    </div>
    </div><!-- end card-->
  </div>

</div>


@endsection

@section('script')

@endsection
