@extends('users::layouts.masteruser')

@section('profile-content')

<?php
$first_name = NULL;
$last_name = NULL;
$email = NULL;
$phone = NULL;
$mobile = NULL;
$role = NULL;

if(isset($input)) {
    $first_name = $input['first_name'];
    $last_name = $input['last_name'];
    $email = $input['email'];
    $phone = $input['phone'];
    $mobile = $input['mobile'];
    $role = $input['role'];
}
?>

    <div class="col-md-12">
    {!! Form::open(array( 'url'=>$modulePath.'/addmultiple', 'class'=>'form-horizontal' )) !!}
        @if(Session::get('email_exists') == TRUE)
            <input type="hidden" name="first_name" value="<?php echo $first_name; ?>">
            <input type="hidden" name="last_name" value="<?php echo $last_name; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="phone" value="<?php echo $phone; ?>">
            <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
            <input type="hidden" name="role" value="<?php echo $role; ?>">

            <div class="box box-solid bg-yellow-gradient">
                <div class="box-header with-border">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>Email address already exists. Add this email to the Facility?</p>
                    <button type="submit" class="btn btn-success">YES</button>
                </div><!-- /.box-header -->
            </div>
        @endif
    {!! Form::close() !!}
        <!-- form start -->
    {!! Form::open(array( 'url'=>$modulePath.'/add', 'id'=>'crudForm', 'name'=>'crudForm', 'class'=>'form-horizontal' )) !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Add New User</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <!--Profile Progress-->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5">
                        <fieldset>
                            <h4>Instructions</h4>
                            <ol>
                                <li>Fill in the form completely making sure required (<strong>*</strong>) fields are filled out.</li>
                                <li><strong>Email</strong> address must be an active address as we will be sending login instructions.</li>
                                <li><strong>Mobile numbers</strong> are mandatory so that users can receive SMS from the system.</li>
                                <li>Temporary <strong>passwords</strong> will be generated for your new users. Once they login the first time, they will be ask to create a new one.</li>
                            </ol>
                        </fieldset>
                    </div>

                    <div class="col-md-7">
                        <fieldset>
                            <h4>Please complete the information below:</h4>
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
                                
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label">First Name</label>
                                        <div class="col-md-8">
                                            {!! Form::text('first_name', $first_name, array('class' => 'form-control required', 'placeholder'=>'First Name',"required"=>"")) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label">Last Name</label>
                                        <div class="col-md-8">
                                            {!! Form::text('last_name', $last_name, array('class' => 'form-control required', 'placeholder'=>'Last Name',"required"=>"")) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-4 control-label">Email Address</label>
                                        <div class="col-md-8">
                                            {!! Form::text('email', $email, array('class' => 'form-control required', 'placeholder'=>'Email',"required"=>"","id"=>"email")) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-md-4 control-label">Phone Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="phone" id="phone" data-mask="" data-inputmask="&quot;mask&quot;: &quot;99-9999999&quot;" class="form-control required" placeholder="Telephone 02-5772886" value="<?php echo $phone; ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-md-4 control-label">Mobile Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="mobile" id="mobile" data-mask="" data-inputmask="&quot;mask&quot;: &quot;0999-9999999&quot;" class="form-control required" placeholder="Mobile 0917-1234567" value="<?php echo $mobile; ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile" class="col-md-4 control-label">Role</label>
                                        <div class="col-md-8">
                                            {!! Form::select('role', $roles, $role, ['class' => 'form-control required', 'id'=> 'role', 'required'=>'required']) !!}
                                        </div>
                                    </div>
                                </div> <!-- box-body end -->
                        </fieldset>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('users') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-success pull-right">Submit</button>
                </div><!-- /.box-footer -->
            </div> <!-- box-body end -->
        </div> <!-- box-primary end -->
    {!! Form::close() !!}
    </div>
@stop


@section('scripts')

    <script src="{{ asset('public/dist/js/pages/users/user_form.js') }}"></script>
@stop
