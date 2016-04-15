@extends('users::layouts.master')
@section('title') ShineOS+ | Change Password @stop
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-6 top40">
			<div class="jumbotron reg-jumbotron">
				<img src="{{ asset('public/dist/img/logos/shinelogo-x-big.png') }}" class="img-responsive" />
				<h2>Change Password</h2>
				<p>Please change temporary password</p>
			</div>
		</div>

		<!--Space filler-->
		<div class="col-md-1">
		</div>
		{!! Form::open(array( 'url'=>'activateaccount/verify/'.$activation_code, 'id'=>'crudForm', 'name'=>'crudForm', 'class'=>'form-horizontal' )) !!}
		<div class="col-md-5 top40 bottom40">
			@if (Session::has('message'))
				<div class="alert alert-dismissible alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif
			<h4>CHANGE PASSWORD FORM</h4>
			<p>
				Your temporary password has been sent to you email address. Kindly check your email.
			</p>
			
			<div class="form-group input-group">
				<span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="New Password" data-content="This is your Administrator Password. Enter a password for your account."><i class="fa fa-question-circle font20"></i></span>
				<input type="password" placeholder="Temporary Password" class="form-control required" id="temporary_password" value="" name="temporary_password" />
			</div>
			
			<div class="form-group input-group">
				<span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="New Password" data-content="This is your Administrator Password. Enter a password for your account."><i class="fa fa-question-circle font20"></i></span>
				<input type="password" placeholder="New Password" class="form-control required" id="password" value="" name="password" />
			</div>

			<div class="form-group input-group">
				<span class="input-group-addon" data-placement="left" data-toggle="popover" data-trigger="hover" title="Password Confirmation" data-content="Please confirm the password you entered above by repeating it here."><i class="fa fa-question-circle font20"></i></span>
				<input type="password" placeholder="Confirm New Password" class="form-control required" id="password_confirm" value="" name="password_confirm" />
			</div>

			<div class="form-group pull-right">
				<input type="submit" name="Register" id="Register" class="btn btn-success" />
				<a href="#" class="btn btn-warning">Cancel</a>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop


@section('footer')
	<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
	<script>
		$('#crudForm').validate({
			rules: {
				password: {
					'required': true,
					'minlength': 4
				},
				password_confirm: {
					equalTo: "#password"
				}
			}
		});
	</script>
@stop