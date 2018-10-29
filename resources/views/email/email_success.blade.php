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


</head>
<body>


    <div class="wrapper">
        <div class="register-background">
            <div class="filter-black"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="jumbotron">
                            <h1 class="text-center">Arrowland</h1>
                            <h5 class="text-center">Your account has been activated! You can now login!</h5>
                            <h5 class="text-center">Username : {{$customer->username}} </h5>



                          </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>

</body>



</html>
