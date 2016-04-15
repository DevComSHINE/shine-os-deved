<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>shineOS | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="{{ csrf_token() }}">
        <!--Global Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700|Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,100' rel='stylesheet' type='text/css'>
        <!-- Bootstrap 3.3.4 -->
        <link href="{{ asset('public/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset('public/dist/css/ShineOS.css') }}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="{{ asset('public/dist/css/skins/skin-blue-light.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
        <link href="{{ asset('public/dist/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <style type="text/css">

            #loginstyle .intro-box * {
                text-shadow: none !important;
            }
            .intro-box h2 {
                font-size: 3em;
            }
            h1, h2 {
                font-weight: 200 !important;
            }
            h4, .smartblue {
                font-weight: 400 !important;
            }
            .smartlitblue {
                color: rgb(114,205,244) !important;
            }
            a.btn:hover {
                color: #000 !important;
            }
            .container {
                margin-top: 50px;
            }
            .jumbotron {
                padding: 40px !important;
                background-color: #FFF;
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
