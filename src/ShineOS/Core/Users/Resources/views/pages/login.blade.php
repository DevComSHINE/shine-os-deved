@extends('users::layouts.masterlogin')
@section('title') SHINE OS+ | Login @stop

@section('content')
    <style>
        body {
                color: #CCC;
                background: #444444;
                background: -moz-linear-gradient(top, #444444 1%, #111111 100%);
                background: -webkit-linear-gradient(top, #444444 1%,#111111 100%);
                background: linear-gradient(to bottom, #444444 1%,#111111 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#444444', endColorstr='#111111',GradientType=0 );
        }
        #loginstyle .intro-box * {
            text-shadow: none !important;
        }
        h2.smartlitblue {
            font-size: 2.5em;
        }
        .modal-content {
            border-radius: 12px;
            overflow:hidden;
        }
        .modal-body {
            padding:0 !important;
        }
    </style>
@stop
@section('content')
    <div class="background_wrapper"></div>
    <div class="overlay"></div>
    <div id="loginstyle" class="row">
        <div class="col-md-1 leftrightfill"></div>
        <div class="intro-box col-md-6">
            <h1>Welcome to <span class="smartblue">ShineOS</span><span class="smartolive">+</span></h1>
            <h2 class="smartlitblue">Developer Edition</h2>
            <p class="lead">SHINE stands for <strong>Secured Health Information Network and Exchange</strong>. A web and mobile-based system that addresses the data management needs of doctors, nurses, midwives, and other allied health professionals in the Philippines.</p>
            <p class="lead">The Developer Edition is the software development kit (SDK) for ShineOS+.</p>

            <h3>
                <a href="http://www.shine.ph/developer" class="btn btn-danger text-center" target="_blank">Learn more</a>
                <a href="http://www.shine.ph/developer/codex" class="btn btn-primary text-center" target="_blank">Documentation</a>
                <a href="http://www.shine.ph/developer/forum" class="btn bg-shine-green text-center" target="_blank">Developer Forum</a>
            </h3>

        </div>
        <div class="form-box col-md-3" id="login-box">

            <div class="header"><i>SHINE OS+</i></div>
                {!! Form::open(array( 'url'=>'login/verify', 'id'=>'loginForm', 'name'=>'loginForm' )) !!}
                <div class="body">
                    <h4>Sign In</h4>
                    @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-success">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif

                    @if (Session::has('warning'))
                        <div class="alert alert-dismissible alert-warning">
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                    @endif

                    <p>Please login with your email/username and password below.</p>

                    <div class="form-group">
                        <input type="text" name="identity" id="identity" class="form-control" placeholder="Username or Email" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me" id="remember_me" value="1" /> Remember me
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-warning btn-block">Sign me in</button>
                    <p><a href="{{ url('forgotpassword') }}">I forgot my password</a></p>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-2 leftrightfill"></div>
        <br clear="all" />
        <div class="loginfooter">
            <a href="http://www.shine.ph/" target="_blank">About</a>
            <a href="http://www.shine.ph/support" target="_blank">Support</a>
            <a href="http://www.shine.ph/developers" target="_blank">Developers</a>
            <a href="http://www.shine.ph/about/privacy-policy/" target="_blank">Privacy</a>
            <a href="http://www.shine.ph/about" target="_blank">Ateneo ShineLabs</a>
            <a href="http://www.shine.ph/" target="_blank">Terms</a> &copy; 2014 - <?php echo date("Y"); ?>
        </div>
        <br clear="all" />
    </div>

    <div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="activateModal">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
<?php /*
<!--begin modal window-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-body">

  <!--CAROUSEL CODE GOES HERE-->
    <!--begin carousel-->
    <div id="myGallery" class="carousel slide" data-interval="false">
    <div class="carousel-inner">

    <div class="item active">
    <img src="http://lorempixel.com/600/400/nature/1" alt="item1">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 0  description.</p>
    </div>
    </div>

    <div class="item">
    <img src="http://lorempixel.com/600/400/nature/2" alt="item2">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 1 description.</p>
    </div>
    </div>

    <div class="item">
    <img src="http://lorempixel.com/600/400/nature/3" alt="item3">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 2  description.</p>
    </div>
    </div>

    <div class="item">
    <img src="http://lorempixel.com/600/400/nature/4" alt="item4">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 3 description.</p>
    </div>
    </div>

    <div class="item">
    <img src="http://lorempixel.com/600/400/nature/5" alt="item5">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 4 description.</p>
    </div>
    </div>

    <div class="item">
    <img src="http://lorempixel.com/600/400/nature/6" alt="item6">
    <div class="carousel-caption">
    <h3>Heading 3</h3>
    <p>Slide 5 description.</p>
    </div>
    </div>
    <!--end carousel-inner--></div>

    <!--Begin Previous and Next buttons-->
    <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myGallery" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span></a>
    <!--end myGallery--></div>


<!--end modal-content--></div>
<!--end modal-dialoge--></div>
<!--end myModal--></div>
@stop

@section('scripts')
    <!--Latest stable release of jQuery Core Library-->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <!--Bootstrap JS-->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
    </script>

    <script>
        $(document).ready(function() {
            $('#myModal').modal('show');
        });
    </script>
@stop
*/ ?>

@section('scripts')
{!! HTML::script('public/dist/plugins/jQuery/jQuery-2.1.4.min.js') !!}
{!! HTML::script('public/dist/js/bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/jQueryUI/jquery-ui.min.js') !!}

    <script>
        /*$(document).ready(function() {
            $('#myModal').modal('show');
        });*/

        $("#activateModal").on("show.bs.modal", function(e) {
            $(this).find(".modal-content").html("");
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });
    </script>
@stop
