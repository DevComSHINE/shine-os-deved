@extends('users::layouts.masterprofile')

@section('profile-content')
    <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-star"></i><h3 class="box-title blue"> Your Profile</h3> &nbsp; <small><em>Completing your profile will help the system work for you better. Head on to your profile to edit.</em></small>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <!--Profile Progress-->
        <div class="box-body">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
              <span class="sr-only">40% Complete (success)</span>
            </div>
            <small> Completeness: 66% </small>
          </div>
        </div><!-- /.box-body -->
      </div>

      <div class="row">
        @include('users::partials.user_nav')
        
        <div class="col-md-9">
           <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">User Role</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                {!! Form::open(array( 'url'=>$modulePath.'/save_role/'.$userInfo->user_id, 'id'=>'crudForm', 'name'=>'crudForm', 'class'=>'form-horizontal' )) !!}
        					<div class="box-body">
                    <select id="role" name="role">
                    @for($i=0; $i < count($role); $i++)
        						  <option value="{{ $role[$i]['role_id'] }}">{{ $role[$i]['role_name'] }}</option>
                    @endfor
                    </select>
        					</div>
                        
        					<div class="box-footer">
        						<input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success pull-right" value="Assign Role" />
        					</div><!-- /.box-footer -->
				        {!! Form::close() !!}
           </div>
        </div>
    </div>
@stop

@section('footer')
	<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('pages/users/user_form.js') }}"></script>
@stop