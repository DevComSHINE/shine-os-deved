<div class="tab-pane" id="employment">
    <fieldset>
        <legend>Employment Information</legend>
        <div class="form-group has-feedback">
            <label class="col-sm-2 control-label">Occupation</label>
            <div class="col-sm-10">
                {!! Form::text('occupation', null, array('class' => 'form-control', 'name'=>'inputOccupation')) !!}
            </div>
            <br clear='all' />
            <label class="col-sm-2 control-label">Company Name</label>
            <div class="col-sm-10">
                {!! Form::text('company_name', null, array('class' => 'form-control', 'name'=>'inputCompanyName')) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Phone</label>
            <div class="col-sm-10">
                {!! Form::text('company_phone', null, array('class' => 'form-control', 'name'=>'inputCompanyPhone')) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Office Unit No.</label>
            <div class="col-sm-4">
                {!! Form::text('company_unitno', null, array('class' => 'form-control', 'name'=>'inputCompanyUnit')) !!}
            </div>
            <label class="col-sm-2 control-label">Office Address</label>
            <div class="col-sm-4">
                {!! Form::text('company_address', null, array('class' => 'form-control', 'name'=>'inputCompanyAddress')) !!}
            </div>

            <label class="col-sm-2 control-label">Region</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="inputCompanyRegion" id="office_region" onchange="loadprovinces(this.value, 'office');">
                    <option value="">-- Choose one --</option>
                    <?php //echo $this->geolocation->get_regions(); ?>
                </select>
            </div>

            <label class="col-sm-2 control-label">Province</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="inputCompanyProvince" id="office_province" onchange="loadcities(this.value, 'office');">
                    <option value="">-- Choose a region --</option>
                </select>
            </div>

            <label class="col-sm-2 control-label">City / Municipality</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="inputCompanyCity" id="office_city" onchange="loadbrgys(this.value, 'office');">
                    <option value="">-- Choose a region --</option>
                </select>
            </div>

            <label class="col-sm-2 control-label">Barangay</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="inputCompanyBrgy" id="office_barangay">
                    <option value="">-- Choose a region --</option>
                </select>
            </div>

            <label class="col-sm-2 control-label">ZIP</label>
            <div class="col-sm-4">
                {!! Form::text('company_zip', null, array('class' => 'form-control', 'name'=>'inputCompanyAddress')) !!}
            </div>

            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="inputCompanyCountry" id="inputCompanyCountry">
                    <option value="PHL">Philippines</option>
                </select>
            </div>
        </div>
    </fieldset>
</div><!-- /.tab-pane -->
