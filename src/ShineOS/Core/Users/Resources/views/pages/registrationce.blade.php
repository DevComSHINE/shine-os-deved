@extends('users::layouts.master')
@section('title') SHINE OS+ | Registration @stop
@section('content')

<?php
    //RJBS solution for form data
    //for clean-up
    $enteredData = Session::get('enteredData');
    if($enteredData) {
        $DOH_facility_code = $enteredData['DOH_facility_code'];
        $facility_name = $enteredData['facility_name'];
        $provider_type = $enteredData['provider_type'];
        $ownership_type = $enteredData['ownership_type'];
        $facility_type = $enteredData['facility_type'];
        $phic_accr_id = $enteredData['phic_accr_id'];
        $first_name = $enteredData['first_name'];
        $last_name = $enteredData['last_name'];
        $password = $enteredData['password'];
        $email = $enteredData['email'];
        $phone = $enteredData['phone'];
        $mobile = $enteredData['mobile'];
    } else {
        $DOH_facility_code = '';
        $facility_name = '';
        $provider_type = '';
        $ownership_type = '';
        $facility_type = '';
        $phic_accr_id = '';
        $first_name = '';
        $last_name = '';
        $email = '';
        $phone = '';
        $mobile = '';
        $password = '';
    }
?>
<style>
    body {
        color: #333;
        background: #F5F5F5;
        background: -moz-linear-gradient(top, #F5F5F5 1%, #EEEEEE 100%);
        background: -webkit-linear-gradient(top, #F5F5F5 1%,#EEEEEE 100%);
        background: linear-gradient(to bottom, #F5F5F5 1%,#EEEEEE 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#F5F5F5', endColorstr='#EEEEEE',GradientType=0 );
    }
    .form-control {
        background-color: #FFF; !important;
        border-color: #AAA !important;
        color: #333;
    }
    .input-group .input-group-addon {
        background-color: #DDD !important;
        border-color: #AAA !important;
        color: #222;
        cursor: pointer;
    }
    i.fa {
        font-size: 18px;
        width: 14px;
    }
    #captcha-image {
        opacity: 0.8 !important;
    }

    .popover {
        color: #000 !important;
    }
    .fa-refresh {
        margin-left: 10px;
    }
    select option {
        color: #000;
    }
    .help-block {
        /*display:none !important;*/
    }
    .regbtn {
        padding: 8px 10px;
        border-color: #AAA !important;
        height: 36px !important;
    }
    .toggler {
        margin-bottom: 0;
    }
    .btn-group > .btn:first-child:not(:last-child):not(.dropdown-toggle) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .input-group div .form-control:first-child {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6 top40">
            <div class="jumbotron reg-jumbotron">
                <img src="{{ asset('public/dist/img/logos/shinelogo-x-big.png') }}" class="img-responsive" />
                <h2>Community Edition Registration</h2>
                <h3>Please complete the information.</h3>
                <p>Registration is required before you can download SHINEOS+ CE. For existing SHINEOS+ Facilities, please download you activate code. For new facilities, fill out the form and click on submit.</p>
            <p><strong>If you want to verify your DOH Facility code, please refer to this website, <a href="http://nhfr.doh.gov.ph/" target="_blank">NHFR</a>.</strong></p>
            </div>

        </div>

        <!--Space filler-->
        <div class="col-md-1">
        </div>

        <div class="col-md-5 top40 bottom40">
            @if (Session::has('message'))
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            @if (Session::has('warning'))
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{ Session::get('warning') }}</p>
                </div>
            @endif

            <h3>REGISTRATION</h3>
            <p>Choose what account you have in SHINEOS+.</p>

            <div class="form-group input-group">
                <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Account Type" data-content="Choose whether you are an existing user or new user."><i class="fa fa-question-circle font20"></i></span>
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default acctbtn required">
                    <i class="fa fa-check"></i> <input type="radio" class="required account_type" name="account_type" id="" autocomplete="off" value="existing" required="required"> Existing User
                  </label>
                  <label class="btn btn-default acctbtn required">
                    <i class="fa fa-check"></i> <input type="radio" class="required account_type" name="account_type" id="" autocomplete="off" value="new" required="required"> New User
                  </label>
                </div>
            </div>

            <fieldset id="newUser" style="display:none;">
            {!! Form::open(array( 'url'=>$modulePath.'/registerce', 'id'=>'newUserForm', 'name'=>'newUserForm', 'class'=>'form-horizontal' )) !!}
                <h4>New User</h4>
                <p>Welcome! All fields are required except PhilHealth Accreditation Number for Private. After registration, your activation code will be sent to your registered email address. You will be directed to the download page after registration.</p>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Ownership Type" data-content="The ownership type of your facility whether you own it as a private clinic or owned by the government. Choose from the list."><i class="fa fa-question-circle font20"></i></span>
                    <div class="btn-group toggler" data-toggle="buttons">
                      <label class="btn btn-default regbtn required @if($ownership_type == 'government') active @endif">
                        <i class="fa fa-check"></i> <input type="radio" class="required ownership_type" name="ownership_type" id="" autocomplete="off" value="government" required="required" @if($ownership_type == 'government') checked="checked" @endif> Government Facility
                      </label>
                      <label class="btn btn-default regbtn required @if($ownership_type == 'private') active @endif">
                        <i class="fa fa-check"></i> <input type="radio" class="required ownership_type" name="ownership_type" id="" autocomplete="off" value="private" required="required"  @if($ownership_type == 'private') checked="checked" @endif> Private Facility
                      </label>
                    </div>
                </div>

                <div class="for_government">
                    <p>
                        The DOH Facility Code is required for Government Facilities. Enter the last 5 digits.
                        If your code is less than 5 digits, add zeros before your code.
                    </p>
                    <div class="form-group input-group ">
                        <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="DOH Facility Code" data-content="This is your DOH Facility Code. This is optional but if you are a Government-owned facility, this is required for your compliance. If you typed in your correct Code, all pertinent fields will be pre-filled for you if data is available."><i class="fa fa-question-circle font20"></i></span>
                        <input type="text" data-mask="" data-inputmask="'mask': 'DOH000000000099999'" placeholder="DOH Facility Code. Enter only last 5 digits. Optional." class="form-control" id="DOH_facility_code" name="DOH_facility_code" value="{{ $DOH_facility_code }}" />

                        <input class="opthidden" type="hidden" name="facility_barangay" value="" />
                        <input class="opthidden" type="hidden" name="facility_city" value="" />
                        <input class="opthidden" type="hidden" name="facility_province" value="" />
                        <input class="opthidden" type="hidden" name="facility_region" value="" />
                    </div>
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Facility Name" data-content="This is your Facility Name. Please enter your valid facility name here. This will identify you from other providers."><i class="fa fa-question-circle font20"></i></span>
                    <input type="text" placeholder="Facility Name" class="form-control required" id="facility_name" value="{{ $facility_name }}" name="facility_name" required />
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Provider Type" data-content="Please indicate what type of provider you are."><i class="fa fa-question-circle font20"></i></span>
                    <select name="provider_type" id="provider_type" class="required form-control" required>
                        <option value="">Select Provider Type</option>
                        <option value="facility" @if($provider_type == 'facility') selected @endif>Facility</option>
                        <option value="individual" @if($provider_type == 'individual') selected @endif>Individual</option>
                    </select>
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Facility Type" data-content="The type of facility you manage. Choose from the list."><i class="fa fa-question-circle font20"></i></span>
                    <select name="facility_type" id="facility_type" class="populate placeholder required form-control">
                        <option value="">Select Facility Type</option>
                        <option class="ot_government" value="Barangay Health Station" @if($facility_type == 'Barangay Health Station') selected @endif>Barangay Health Station</option>
                        <option class="ot_private" value="Birthing Home" @if($facility_type == 'Birthing Home') selected @endif>Birthing Home</option>
                        <option class="ot_government" value="City Health Office" @if($facility_type == 'City Health Office') selected @endif>City Health Office</option>
                        <option class="ot_government" value="District Health Office" @if($facility_type == 'District Health Office') selected @endif>District Health Office</option>
                        <option class="ot_private" value="Hospital" @if($facility_type == 'Hospital') selected @endif>Hospital</option>
                        <option class="ot_government" value="Main Health Center" @if($facility_type == 'Main Health Center') selected @endif>Main Health Center</option>
                        <option class="ot_government" value="Municipal Health Office" @if($facility_type == 'Municipal Health Office') selected @endif>Municipal Health Office</option>
                        <option class="ot_government" value="Provincial Health Office" @if($facility_type == 'Provincial Health Office') selected @endif>Provincial Health Office</option>
                        <option class="ot_government" value="Rural Health Unit" @if($facility_type == 'Rural Health Unit') selected @endif>Rural Health Unit</option>
                        <option class="ot_private" value="Private Clinic" @if($facility_type == 'Private Clinic') selected @endif>Private Clinic</option>
                    </select>
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Philhealth Accreditation NUmber" data-content="This is your PhilHealth Accreditation Number. This is required if your ownership type if Government."><i class="fa fa-question-circle font20"></i></span>
                    <input type="text" placeholder="PhilHealth Accreditation Number" class="form-control" id="phic_accr_id" value="{{ $phic_accr_id }}" name="phic_accr_id" />
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Administrator Name" data-content="Please provide the first name and last name of your facility's administrator"><i class="fa fa-question-circle font20"></i></span>
                    <div class="row col-md-6">
                        <input type="text" placeholder="Administrator First Name" class="form-control required" id="first_name" value="{{ $first_name }}" name="first_name" />
                    </div>

                    <div class="col-md-6">
                        <input type="text" placeholder="Administrator Last Name" class="form-control required" id="last_name" value="{{ $last_name }}" name="last_name" />
                    </div>
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Administrator Email Address" data-content="The email address of your administrator."><i class="fa fa-question-circle font20"></i></span>
                    <input type="text" placeholder="Administrator Email Address" class="form-control required" id="email" value="{{ $email }}" name="email" />
                </div>

                <div class="form-group input-group">
                    <div class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Administrator Phone Number" data-content="The telephone number of your administrator.">
                    <i class="fa fa-phone font20"></i>
                    </div>
                    <input type="text" name="phone" id="phone" data-mask="" data-inputmask="&quot;mask&quot;: &quot;99-9999999&quot;" class="form-control required" placeholder="Telephone 02-5772886" value="{{ $phone }}" />
                </div><!-- /.input group -->

                <div class="form-group input-group">
                    <div class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Administrator Mobile Number" data-content="The mobile number of your administrator.">
                    <i class="fa fa-mobile font20"></i>
                    </div>
                    <input type="text" name="mobile" id="mobile" data-mask="" data-inputmask="&quot;mask&quot;: &quot;0999-9999999&quot;" class="form-control required" placeholder="Mobile 0917-1234567" value="{{ $mobile }}" />
                </div><!-- /.input group -->

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Administrator Password" data-content="This is your Administrator Password. Enter a password for your account."><i class="fa fa-question-circle font20"></i></span>
                    <input type="password" placeholder="Administrator Password" class="form-control required password" id="password" value="" name="password" />
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Password Confirmation" data-content="Please confirm the password you entered above by repeating it here."><i class="fa fa-question-circle font20"></i></span>
                    <input type="password" placeholder="Confirm Administrator Password" class="form-control required confirmPassword" id="password_confirm" value="" name="password_confirm" />
                </div>

                <div class="form-group input-group has-succes">
                    <img src="{{ url('registration/captcha') }}" alt="Please verify if you are a human" id="captcha-image" />
                    <a href="#" class="fa fa-refresh captcha-refresh">&nbsp;</a>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Captcha" data-content="Please verify if you are a human."><i class="fa fa-question-circle font20"></i></span>
                    <input id="test_captcha" placeholder="Copy the code above." name="test_captcha" value="" type="text" class="form-control required captcha" />
                </div>

                <div class="form-group pull-right">
                    <input type="submit" name="Register" id="btnRegister" class="btn btn-success" value="Register" />
                    <a href="{{ url('/') }}" class="btn btn-warning">Cancel</a>
                </div>
                {!! Form::close() !!}
            </fieldset>

            <fieldset id="oldUser" style="display:none;">
                {!! Form::open(array( 'url'=>$modulePath.'/getactivation', 'id'=>'oldUserForm', 'name'=>'oldUserForm', 'class'=>'form-horizontal' )) !!}
                <h4>Existing User</h4>
                <p>Welcome! Please enter your username(email) and password then click on Download Activation Code. An email will be sent to your email address with your activation code. You will be directed to the download page once your account is confirmed.</p>

                <div class="form-group">
                        <input type="text" name="identity" id="identity" class="form-control" placeholder="Username or Email" />
                </div>
                <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                </div>
                <div class="form-group pull-right">
                    <input type="submit" name="Download" id="btnDownload" class="btn btn-success" value="Download Activation Code" />
                    <a href="{{ url('/') }}" class="btn btn-warning">Cancel</a>
                </div>
                {!! Form::close() !!}
            </fieldset>
        </div>
    </div>
</div>
@stop


@section('footer')
    <script src="{{ asset('public/dist/plugins/input-mask/inputmask.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/input-mask/inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/input-mask/inputmask.extensions.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('public/dist/js/pages/registration.js') }}"></script>
@stop

