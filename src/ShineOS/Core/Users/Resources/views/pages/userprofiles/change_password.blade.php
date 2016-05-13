<h4>Change Password</h4>

{!! Form::open(array( 'url'=>$modulePath.'/changepassword/'.$userInfo->user_id, 'class'=>'form-horizontal' )) !!}
<div class="box-body">
    <div class="form-group">
        <label for="inputCurrentPassword" class="col-sm-2 control-label">Current Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" value="" />
        </div>
    </div>
    <div class="form-group">
        <label for="inputNewPassword" class="col-sm-2 control-label">New Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control password" id="newPassword" name="newPassword" placeholder="New Password" value="" />
        </div>
    </div>
    <div class="form-group">
        <label for="inputVerifyPassword" class="col-sm-2 control-label">Verify Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control confirmPassword" id="confirmPassword" name="confirmPassword" placeholder="Verify Password" value="" />
        </div>
    </div>
</div>
<div class="box-footer">
<input type="submit" class="btn btn-success pull-right"/>
</div>
{!! Form::close() !!}
