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
            box-shadow: 0 0 75px rgba(0,0,0,.25);
        }
    </style>
    <div id="loginstyle" class="row">
        <div class="col-md-4 leftrightfill"></div>
        <div class="form-box col-md-4" id="login-box">

            {!! Form::open(array( 'url'=>'patient/forgotpassword/changepassword_request', 'id'=>'ChangePassword', 'name'=>'ChangePassword' )) !!}
                <div class="body">
                    <h4>Forgot Password</h4>

                    @if (Session::has('success'))
                        <div class="alert alert-dismissible alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-success">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif

                    @if (Session::has('warning'))
                        <div class="alert alert-dismissible alert-warning">
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                    @else

                    <p>You may update your password below.</p>

                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="verify_password" id="verify_password" class="form-control" placeholder="Re-enter Password" required />
                    </div>
                    @endif
                </div>
                @if (!Session::has('warning'))
                <div class="footer">
                    <input type="hidden" id="forgot_password_code" name="forgot_password_code" value="@if(isset($forgotPassword)){{$forgotPassword->forgot_password_code}}@endif">
                    <button type="submit" class="btn bg-shine-green btn-block">Submit</button>
                </div>
                @endif
            {!! Form::close() !!}
        </div>
        <div class="col-md-4 leftrightfill"></div>
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
