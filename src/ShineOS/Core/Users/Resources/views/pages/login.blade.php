@extends('users::layouts.masterlogin')
@section('title') ShineOS+ | Login @stop

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
        .background_wrapper {
            background: url({{ asset('public/dist/img/saas-bak.jpg') }}) no-repeat;
            background-size: cover;
            left: 0;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 2;
        }
        .overlay {
            background-color: #000;
            left: 0;
            top: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 3;
            opacity: .55;
        }
        h2.smartlitblue {
            font-size: 2.5em;
        }
    </style>
    <div class="background_wrapper"></div>
    <div class="overlay"></div>
    <div id="loginstyle" class="row">
        <div class="col-md-1 leftrightfill"></div>
        <div class="intro-box col-md-6">
            <h1>Welcome to <span class="smartblue">ShineOS</span><span class="smartolive">+</span> v3.0</h1>
            <h2 class="smartlitblue">The First Health Care Exchange System</h2>
            <p class="lead">SHINE stands for <strong>Secured Health Information Network and Exchange</strong>. A web and mobile-based system that addresses the data management needs of doctors, nurses, midwives, and other allied health professionals in the Philippines.</p>
            <h3>
                <a href="{{ url('registration') }}" class="btn btn-primary text-center">Register for FREE!</a>
                <a href="http://www.shine.ph/" class="btn btn-danger text-center" target="_blank">Learn more</a>
                <a href="http://www.shine.ph/developer" class="btn bg-shine-green text-center" target="_blank">Developer</a>
            </h3>

        </div>
        <div class="form-box col-md-3" id="login-box">

            <div class="header"><i>ShineOS+</i></div>

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
                    <button type="submit" class="btn bg-shine-green btn-block">Sign me in</button>

                    <p><a href="{{ url('forgotpassword') }}">I forgot my password</a></p>

                </div>
            {!! Form::close() !!}

          <!--   <div class="social margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div> -->
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

@stop
