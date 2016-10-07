@extends('users::layouts.masterlogin')
@section('title') SHINE OS+ | Login @stop

@section('content')
    <style>
        body {
            color: #333;
            background: #F5F5F5;
            background: -moz-linear-gradient(top, #F5F5F5 1%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #F5F5F5 1%,#EEEEEE 100%);
            background: linear-gradient(to bottom, #F5F5F5 1%,#EEEEEE 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#F5F5F5', endColorstr='#EEEEEE',GradientType=0 );
        }
        .loginfooter, .loginfooter a {
            color: #555 !important;
        }
        #login-box {

        }
        .jumbotron {
            background-color: #555;
            border-radius: 16px;
        }
        .jumbotron h1 {
            color: #00c0ef !important;
        }
    </style>
    <div id="loginstyle" class="row">
        <div class="col-md-1 leftrightfill"></div>
        <div class="intro-box col-md-6">
            <div class="jumbotron reg-jumbotron">
            <h1 class="text-white">Welcome to <span class="smartolive">SHINE OS</span><span class="text-white">+</span></h1>
            <h2 class="text-white">Version 3.0</h2>
            <h4>IMPORTANT NOTICE</h4>
            <p class="lead">In this new version of SHINE OS+, we need to <b>reset</b> your password to a new one. Please reset your password by entering your account email address and a new password.</p>
            </div>
        </div>
        <div class="form-box col-md-3" id="login-box">

            <div class="header"><i>SHINE OS+</i></div>

            {!! Form::open(array( 'url'=>'changeoldpassword', 'id'=>'ChangeOldPassword', 'name'=>'ChangeOldPassword' )) !!}
                <div class="body">
                    <h4>Forgot Password</h4>

                    @if (Session::has('success'))
                        <div class="alert alert-dismissible alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    @if (Session::has('warning'))
                        <div class="alert alert-dismissible alert-warning">
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                    @endif

                    <p>You may update your password below.</p>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="verify_password" id="verify_password" class="form-control" placeholder="Re-enter Password" required />
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-shine-green btn-block">Submit</button>
                </div>
            {!! Form::close() !!}
        </div>

        <div class="col-md-2 leftrightfill"></div>
        <br clear="all" />
        <div class="loginfooter">
            <a href="">About</a>
            <a href="">Tour</a>
            <a href="">Support</a>
            <a href="">Developers</a>
            <a href="">Privacy</a>
            <a href="">Terms</a> &copy; 2014 - 2015
        </div>
    </div>

@stop

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('pages/login/changepassword.js') }}"></script>
@endsection
