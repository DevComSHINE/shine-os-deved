@extends('users::layouts.masterlogin')
@section('title') SHINE OS+ | Forgot Password @stop

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
            box-shadow: 0 0 75px rgba(0,0,0,.25);
        }
    </style>
    <div id="loginstyle" class="row">
        <div class="col-md-4 leftrightfill"></div>
        <div class="form-box col-md-4" id="login-box">

            <div class="header"><i>ShineOS+</i></div>

            {!! Form::open(array( 'url'=>'forgotpassword/send', 'id'=>'forgotPasswordForm', 'name'=>'forgotPasswordForm' )) !!}
                <div class="body">
                    <h4>Forgot Password</h4>

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

                    <p>Please enter your email address below. We will send you steps to change your password.</p>

                    <div class="form-group">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email Address" required />
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-shine-green btn-block">Submit</button>
                    <p><a href="{{ url('login') }}">Back to Login</a></p>
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
        <div class="col-md-4 leftrightfill"></div>
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

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('pages/login/forgotpassword.js') }}"></script>
@endsection
