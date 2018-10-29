@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
                              <h1 class="main-title float-left">My Profile</h1>
                              <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active">Profile</li>
                              </ol>
                              <div class="clearfix"></div>
                      </div>
    </div>
</div>

@if(Session::has('flash_message_error'))
<div class="alert alert-danger alert-block">
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


<div class="row">

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
          <div class="card-header">
            <h3><i class="fa fa-user"></i> Profile details</h3>

          </div>

          <div class="card-body">


            <form action="{{route('profile')}}" method="post" enctype="multipart/form-data" novalidate="novalidate"  id="form-profile" name="form-profile">
              {{csrf_field()}}

            <div class="row">

            <div class="col-lg-9 col-xl-9">

              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                <label>Full name (required)</label>
                <input class="form-control" id="name" name="name" type="text" value="{{Auth::user()->name}}" />
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group">
                <label>Valid Email (required)</label>
                <input class="form-control" name="email" type="email" value="{{Auth::user()->email}}" />
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group">
                <label>Username (required)</label>
                <input class="form-control" name="username" type="text" value="{{Auth::user()->username}}" />
                </div>
                </div>

              </div>

              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                <label>Current Password (leave empty not to change)</label>
                <input class="form-control" name="cur_password" type="password" id="cur_pass" />
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group">
                <label>New Password (leave empty not to change)</label>
                <input class="form-control" name="new_password" type="password" id="new_pass" />
                </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">Edit profile</button>
                </div>
              </div>

            </div>



            <div class="col-lg-3 col-xl-3 border-left">
              <!-- <b>Latest activity</b>: Dec 06 2017, 22:23
              <br />
              <b>Register date: </b>: Nov 24 2017, 20:32
              <br />
              <b>Register IP: </b>: 123.456.789 -->

              <div class="m-b-10"></div>

              <div id="avatar_image">
                <img alt="image" style="max-width:100px; height:auto;" src="{{asset('images/backend/user/'.Auth::user()->image)}}" />
                <br />
                <i class="fa fa-trash-o fa-fw"></i> <a class="delete_image" href="#">Remove avatar</a>

              </div>
              <div id="image_deleted_text"></div>


              <div class="m-b-10"></div>

              <div class="form-group">
              <label>Change avatar</label>
              <input type="file" name="image" class="form-control">
              </div>

            </div>
            </div>

            </form>

    </div>
    <!-- end card-body -->

  </div>
  <!-- end card -->

</div>
<!-- end col -->

</div>

@endsection

@section('script')

<script type="text/javascript">
$("#form-profile").validate({
  rules: {
    name: {
      required:true,
      minlength:5,
      maxlength:45
    },
    username: {
      required:true,
      minlength:5,
      maxlength:15

    },
    email: {
      required:true,
      email:true
    },
    cur_password: {
      minlength:5,
      maxlength:20,
    },
    new_password: {
      minlength:5,
      maxlength:20,
    }
  },
  errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').addClass('text-danger');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('text-danger');
			$(element).parents('.form-group').addClass('text-success');
		}

});

</script>

@endsection
