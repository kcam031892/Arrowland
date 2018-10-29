<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/paper_img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Arrowland | Login</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="{{asset('css/backend/login/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/backend/login/ct-paper.css')}}" rel="stylesheet" />
    <link href="{{asset('css/backend/login/demo.css')}}" rel="stylesheet" />
    <link href="{{asset('css/backend/login/examples.css')}}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <!-- <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'> -->

</head>
<body>


    <div class="wrapper">
        <div class="register-background">
            <div class="filter-black"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 ">
                            <div class="register-card">
                                <h3 class="title">Arrowland</h3>

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



                                <form class="form-login" method="POST" action="{{url('/admin')}}" novalidate="novalidate">
                                  {{csrf_field()}}
																	<div class="form-group">
																		<label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" autofocus>

																	</div>

																	<div class="form-group">
																		<label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password">

																	</div>



                                    <button class="btn btn-danger btn-block">Login</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

</body>

<script src="{{ asset('js/backend/jquery.min.js') }}"></script>
<script src="{{ asset('js/backend/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/backend/jquery.validate.min.js') }}"></script>
<!-- <script src="../assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<script src="../bootstrap3/js/bootstrap.js" type="text/javascript"></script> -->

<!--  Plugins -->
<!-- <script src="../assets/js/ct-paper-checkbox.js"></script>
<script src="../assets/js/ct-paper-radio.js"></script>
<script src="../assets/js/bootstrap-select.js"></script>
<script src="../assets/js/bootstrap-datepicker.js"></script>

<script src="../assets/js/ct-paper.js"></script> -->

<script type="text/javascript">

$('.form-login').validate({
	rules: {
		username: {
			required:true
		},
		password:{
			required:true
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

</html>
