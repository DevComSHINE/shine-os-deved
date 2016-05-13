<h4>Change User Role</h4>

 {!! Form::open(array( 'url'=>$modulePath.'/save_role/'.$userInfo->user_id, 'id'=>'crudForm', 'name'=>'crudForm', 'class'=>'form-horizontal' )) !!}
  <div class="box-body">
        <select id="role" name="role" class="form-control">
        @for($i=0; $i < count($role); $i++)
          @if($userRole->role_name == $role[$i]['role_name'])
            <option value="{{ $role[$i]['role_id'] }}" selected>{{ $role[$i]['role_name'] }}</option>
          @else
            <option value="{{ $role[$i]['role_id'] }}">{{ $role[$i]['role_name'] }}</option>
          @endif
        @endfor
        </select>
  </div>
            
  <div class="box-footer">
    <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success pull-right" value="Assign Role" />
  </div><!-- /.box-footer -->
{!! Form::close() !!}