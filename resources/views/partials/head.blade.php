<meta charset="UTF-8">
<title>ShineOS+ v3.0</title> <!--Dynamic title-->
<!-- Tell the browser to be responsive to screen width -->
<meta name="description" content="ShineOS+ EMR, the first Philippine Health Exchange System">
<meta name="author" content="ShineOS+">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-title" content="ShineOS+">
<link href="{{ asset('public/dist/img/icon.png') }}"
      sizes="152x152"
      rel="apple-touch-icon">
<link rel='shortcut icon' type='image/x-icon' href='{{ asset('public/favicon.ico') }}' />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="_token" content="{{ csrf_token() }}">

{!! HTML::style('public/dist/plugins/jQueryUI/jquery-ui-1.10.4.min.css') !!}
<!-- Bootstrap 3.3.4 helloooo-->
{!! HTML::style('public/dist/css/bootstrap.min.css') !!}
<!-- Bootstrap Switch -->
{!! HTML::style('public/dist/css/bootstrap-switch.min.css') !!}
<!-- FontAwesome 4.3.0 -->
{!! HTML::style('public/dist/css/font-awesome.min.css') !!}
<!-- Ionicons 2.0 -->
{!! HTML::style('public/dist/css/ionicons.min.css') !!}
<!-- Morris chart -->
{!! HTML::style('public/dist/plugins/morris/morris.css') !!}
<!-- jvectormap -->
{!! HTML::style('public/dist/plugins/jvectormap/jquery-jvectormap-1.2.2.css') !!}
<!-- Daterange picker -->
{!! HTML::style('public/dist/plugins/daterangepicker/daterangepicker.css') !!}
<!-- Time picker -->
{!! HTML::style('public/dist/plugins/timepicker/bootstrap-timepicker.min.css') !!}
<!-- iCheck -->
{!! HTML::style('public/dist/plugins/iCheck/square/_all.css') !!}

<!-- Bootstrap datatables -->
{!! HTML::style('public/dist/plugins/datatables/dataTables.bootstrap.css') !!}
<!-- Select2 -->
{!! HTML::style('public/dist/plugins/select2/select2.min.css') !!}
{!! HTML::style('public/dist/css/ShineOS.css') !!}
{!! HTML::style('public/dist/css/colors.css') !!}

<!--Put customized CSS here-->
@yield('heads')

<!--Major JS Scripts -->
{!! HTML::script('public/dist/plugins/jQuery/jQuery-2.1.4.min.js') !!}
{!! HTML::script('public/dist/js/bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/jQueryUI/jquery-ui.min.js') !!}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
