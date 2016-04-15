@extends('users::layouts.masteruser')

@section('profile-content')
    <div class="col-md-12">
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
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label">First Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label">Last Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-4 control-label">Email Address</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-md-4 control-label">Phone Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="phone" id="phone" data-mask="" data-inputmask="&quot;mask&quot;: &quot;99-9999999&quot;" class="form-control" placeholder="Telephone 02-5772886" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-md-4 control-label">Mobile Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="mobile" id="mobile" data-mask="" data-inputmask="&quot;mask&quot;: &quot;0999-9999999&quot;" class="form-control" placeholder="Mobile 0917-1234567" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile" class="col-md-4 control-label">Role</label>
                                        <div class="col-md-8">
                                            <select id="role" name="role" class="form-control">
                                                <option value="">-- Select role --</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                                @endforeach
                                            </select>
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
