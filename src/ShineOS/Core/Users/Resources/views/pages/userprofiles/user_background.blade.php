<h4>Background</h4>
<!-- form start -->
{!! Form::open(array( 'url'=>$modulePath.'/updatebackground/'.$userInfo->user_id, 'id'=>'UserBackgroundForm', 'name'=>'UserBackgroundForm', 'class'=>'form-horizontal' )) !!}
    <div class="box-body">
        <div class="form-group">
            <label for="inputLastName" class="col-sm-2 control-label">Profession</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="profession" name="profession" placeholder="Profession" value="{{ $userMd ? $userMd->profession : NULL }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="professional_license_number" class="col-sm-2 control-label">License Number</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="professional_license_number" name="professional_license_number" placeholder="License Number" value="{{ $userMd ? $userMd->professional_license_number : NULL }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="med_school" class="col-sm-2 control-label">Medical School</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="med_school" name="med_school" placeholder="Med School" value="{{ $userMd ? $userMd->med_school : NULL }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="residency_trn_inst" class="col-sm-2 control-label">Residency</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="datepicker" name="residency_trn_inst" placeholder="Residency" value="{{ $userMd ? $userMd->residency_trn_inst : NULL }}" />
                <!--<input type="text" class="form-control" id="datepicker" id="residency_trn_inst" name="residency_trn_inst" placeholder="Residency" value="{{ $userMd ? $userMd->residency_trn_inst : NULL }}" />-->
            </div>
        </div>
        <div class="form-group">
            <label for="residency_grad_yr" class="col-sm-2 control-label">Year Graduated</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="datepicker" name="residency_grad_yr" placeholder="Year Graduated" value="{{ $userMd ? $userMd->residency_grad_yr : NULL }}" />
                <!--<input type="text" class="form-control" id="datepicker"id="residency_grad_yr" name="residency_grad_yr" placeholder="Year Graduated" value="{{ $userMd ? $userMd->residency_grad_yr : NULL }}" />-->
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right">Update Background</button>
    </div><!-- /.box-footer -->
{!! Form::close() !!}
