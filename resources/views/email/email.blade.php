<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<style media="screen">
	body {
		margin:0;
		padding:0;
	}
		.container {
			background-color: #262525;
			width: 800px;
			position: absolute;
			top: 40%;
			left: 50%;
			padding: 15px;
			transform: translate(-50%,-50%);
			color: #fff;

		}
		.text-center {
			text-align: center;
		}
		.logo img {
			position: relative;
			left: 45%;

			height: 100px;

		}
	</style>
	<body>

		<div class="container">
			<div class="box">
				<div class="logo">
					<img src="{{asset('images/backend/logo2.png')}}" alt="">

				</div>

				<div class="text-content">
					<div class="jumbotron">
					  <h1 class="text-center">Arrowland</h1>
					  <h5 class="text-center">Click the Link to Verify Your Account</h5>
						<h5>Username : {{$customer->username}} </h5>
					  <h5>Link<a href="{{ url('/verifyemail/'.$customer->verification_code) }}">{{ url('/verifyemail/'.$customer->verification_code) }}</a> </h5>



					</div>

				</div>

			</div>

		</div>

	</body>
</html>
