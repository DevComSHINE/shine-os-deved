
			<div class="form-group">
	          <label for="inputRoleName" class="col-sm-3 control-label">Name</label>
	          <div class="col-sm-9">
	            {!! Form::text('role_name', null, array('class' => 'form-control', 'name'=>'inputRoleName')) !!}
	          </div>
	        </div>

	       <!--  <div class="form-group">
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
	        </div> -->
	     	<h4>Access Level</h4>
	     	<div class="row">
	     		<div class="col-md-3">
	     			{!! Form::checkbox('role_read', null, array('class' => 'form-control', 'name'=>'role_read')) !!}
	     			View 		
	     		</div>
				
				<div class="col-md-3">
					{!! Form::checkbox('role_create', null, array('class' => 'form-control', 'name'=>'role_create')) !!}
	     			Add 		
	     		</div>

	     		<div class="col-md-3">
	     			{!! Form::checkbox('role_update', null, array('class' => 'form-control', 'name'=>'role_update')) !!}
	     			Edit  		
	     		</div>

	     		<div class="col-md-3">
	     			{!! Form::checkbox('role_delete', null, array('class' => 'form-control', 'name'=>'role_delete')) !!}
	     			Delete		
	     		</div>
	     	</div>
	    </div><!-- /.col-md-6 -->

	    <div class="col-md-6">
	      	<h4>Features</h4>
	      	<ul class="list-group">
		      	@foreach ($role_features as $val)
		      		<li class="list-group-item">
		      			@if (isset($roleItems))
				      		{!! Form::checkbox('feature[]', $val['feature_id'], $roleItems->features->contains($val['feature_id']) ? true : false) !!}
				      	@else
				      		{!! Form::checkbox('feature[]', $val['feature_id']) !!}
			      		@endif
			      		{{ $val['feature_name'] }}
		      		</li>
		       		<!-- <input type="checkbox" name="feature[]" id="{{ $val['feature_id'] }}" value="{{ $val['feature_id'] }}"> {{ $val['feature_name'] }} <br /> -->
		        @endforeach
	        </ul>
	    </div><!-- /.col-md-6 -->
	  </div><!-- /.row -->
	</div><!-- /.box-body -->

	<div class="box-footer clearfix">
	  <div class="pull-right">
	    {!! Form::submit('Save Role') !!}
	  </div>
	</div>
