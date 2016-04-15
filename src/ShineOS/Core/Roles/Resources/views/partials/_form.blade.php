
		<div class="form-group">
	          <label for="inputRoleName" class="col-sm-3 control-label">Name</label>
	          <div class="col-sm-9">
	            <input type="text" class="form-control" name="inputRoleName" id="inputRoleName" placeholder="Role Name" value="">
	          </div>
	        </div>

	        <div class="form-group">
	          <label for="inputRoleDesc" class="col-sm-3 control-label">Description</label>
	          <div class="col-sm-9">
	            <input type="text" class="form-control" name="inputRoleDesc" id="inputRoleDesc" placeholder="Role Description" value="">
	          </div>
	        </div>

	        <div class="form-group">
	          <label for="inputRoleDesc" class="col-sm-3 control-label">Status</label>
	          <div class="col-sm-9">
	            <select class="form-control" name="inputRoleStatus" id="inputRoleStatus">
	              <option value="1">Active</option>
	              <option value="0">Inactive</option>
	            </select>
	          </div>
	        </div>
	    </div><!-- /.col-md-6 -->

	    <div class="col-md-6">
	      <h4>Access Level</h4>
	      <input type="checkbox" name="role_read" value="1"> View <br />
	      <input type="checkbox" name="role_create" value="1"> Add <br />
	      <input type="checkbox" name="role_update" value="1"> Edit <br />
	      <input type="checkbox" name="role_delete" value="1"> Delete <br />
	    </div><!-- /.col-md-6 -->
	  </div><!-- /.row -->

	  <div class="row">
	    <div class="col-md-12">
	      <h4>Features</h4>
	      	@foreach ($role_features as $val)
	        <input type="checkbox" name="feature[]" id="{{ $val['feature_id'] }}" value="{{ $val['feature_id'] }}"> {{ $val['feature_name'] }} <br />
	        @endforeach
	    </div><!-- /.col-md-12 -->
	  </div><!-- /.row -->

	</div><!-- /.box-body -->

	<div class="box-footer clearfix">
	  <div class="pull-right">
	    {!! Form::submit('Save Role') !!}
	  </div>
	</div>
