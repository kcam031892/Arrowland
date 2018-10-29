<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Arrowland | AdminPanel</title>
		<meta name="description" content="Arrowland">
		<meta name="author" content="Arrowland">

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('images/backend/logo2.png') }}">

		<!-- Bootstrap CSS -->
		<link href="{{ asset('css/backend/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

		<!-- Font Awesome CSS -->
		<link href="{{ asset('fonts/backend/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

		<!-- Custom CSS -->
		<link href="{{ asset('css/backend/style.css')}}" rel="stylesheet" type="text/css" />

		<!-- BEGIN CSS for this page -->
		<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/> -->
		<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/dataTables.bootstrap4.min.css')}}">

		<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/jquery.fancybox.min.css')}}">



		<!-- END CSS for this page -->
		<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/parsley.css')}}">

		<link href="{{ asset('js/backend/plugins/jquery.filer/css/jquery.filer.css')}}" rel="stylesheet" />


</head>

<body class="adminbody">

	<div class="se-pre-con">

	</div>

<div id="main">

	<!-- top bar navigation -->
	@include('layouts.backend.header')

	<!-- End Navigation -->
	@include('layouts.backend.sidebar')


	<!-- Left Sidebar -->

	<!-- End Sidebar -->


    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">
				<div class="alert alert-success" id="success-alert" style="display: none;">
					<button type="button" class="close" ></button>
					<span id="dx"><strong></strong></span>
					<span id="success-message">fuck you</span>

				</div>

				@yield('content')




            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->



</div>
<!-- END main -->

@include('layouts.backend.footer')

<script src="{{ asset('js/backend/modernizr.min.js') }}"></script>
<script src="{{ asset('js/backend/jquery.min.js') }}"></script>
<script src="{{ asset('js/backend/moment.min.js') }}"></script>

<script src="{{ asset('js/backend/popper.min.js') }}"></script>
<script src="{{ asset('js/backend/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/backend/jquery.validate.min.js') }}"></script>

<script src="{{ asset('js/backend/detect.js') }}"></script>
<script src="{{ asset('js/backend/fastclick.js') }}"></script>
<script src="{{ asset('js/backend/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/backend/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/backend/sweetalert2.js') }}"></script>
<script src="{{ asset('js/backend/jquery.fancybox.min.js')}}"></script>

<!-- App js -->
<script src="{{ asset('js/backend/pikeadmin.js') }}"></script>
<script src="{{ asset('js/backend/plugins/parsleyjs/parsley.min.js')}}"></script>

<!-- BEGIN Java Script for this page -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script> -->
	<script src="{{ asset('js/backend/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('js/backend/dataTables.bootstrap4.min.js')}}"></script>

	<!-- Counter-Up-->
	<script src="{{ asset('js/backend/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('js/backend/plugins/counterup/jquery.counterup.min.js') }}"></script>
	<script src="{{ asset('js/backend/plugins/jquery.filer/js/jquery.filer.min.js')}}"></script>

	<script src="{{ asset('js/backend/main.js') }}"></script>



	<script>
		$(document).ready(function() {
			// data-tables
			$('#example1').DataTable();

			// counter-up
			$('.counter').counterUp({
				delay: 10,
				time: 600
			});



			$.getJSON("{{url('api/notification/admin/count')}}",function($data){
				if($data.count > 0) {
					$('.noti-red').addClass('notif-bullet');
					$('.notification-count').html($data.count);
				}else {
					$('.noti-red').removeClass('notif-bullet');
				}
			});

			$.getJSON("{{url('api/notification/admin/list')}}", function($data) {

				var html = "";
				$.each($data.notificationList, function(k,v) {

					if(v.notificationable_type == "Reservation") {
						var url = "{{url('/admin/range-rental/')}}/"+v.id+"/detail";

					}else {
						var url = "{{url('/admin/payment/')}}/"+v.id+"/detail";
					}

					console.log(v.status);

					if(v.status == "Unread") {

						html += '<a href="'+url+'" class="dropdown-item notify-item bg-primary">'+
										'<p class="notify-details"><b>'+v.notificationable_type+'</b><span>'+v.message+'</span><small class="text-muted">'+v.time+'</small></p>'+
										'</a>';

					}else {

						html += '<a href="'+url+'" class="dropdown-item notify-item">'+
										'<p class="notify-details"><b>'+v.notificationable_type+'</b><span>'+v.message+'</span><small class="text-muted">'+v.time+'</small></p>'+
										'</a>';
					}





					$('.notifcation-body').html(html);
				});


			});


		});




	</script>


	@yield('script')



<!-- END Java Script for this page -->

</body>
</html>
