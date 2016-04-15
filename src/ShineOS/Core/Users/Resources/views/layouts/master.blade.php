<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ShineOS+ | Facility Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.4 -->
    	<link href="{{ asset('public/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
       	<!-- Theme style -->
	    <link href="{{ asset('public/dist/css/ShineOS.css') }}" rel="stylesheet" type="text/css" />
	    <!-- AdminLTE Skins. Choose a skin from the css/skins 
	         folder instead of downloading all of them to reduce the load. -->
	    <link href="{{ asset('public/dist/css/skins/skin-blue-light.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
   		<link href="{{ asset('public/dist/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <style type="text/css">
        	body {
			  color: #333;
			  background: #F5F5F5;
			}
			.reg-jumbotron {  
				padding: 60px !important;
			}
            .top40 { margin-top: 40px;}
            .bottom40 {margin-bottom: 40px;}
            
            .select2-container .select2-choice {
                height: 35px;
                padding: 4px 0 0 12px;
            }
            .font20 { font-size: 20px !important; width: 18px;}
            .input-group-addon { cursor: pointer;}
            .select2-container { width: 100%; }
            .fa { color: rgb(0,129,198) !important; }
            .form-group {
                margin-bottom: 8px;
            }
            .has-error .form-control, .has-error .select2-container .select2-choice {
              background-color: #f2dede;
              background-image: none;
              border-color: #a94442;
            }
            .help-block {
                position: absolute;
                right: 50px;
                top: 4px;
                z-index: 100;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
<body>
@yield('content')
@include('partials.footer')
@yield('footer')
</body>
</html>