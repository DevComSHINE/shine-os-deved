 <div class="tab-pane" id="family">
    <fieldset>
        <legend>Family Information</legend>
        <div class="form-group">
            <label class="col-sm-2 control-label">Number of Households Members</label>
            <div class="col-sm-4">
                {!! Form::text('ctr_householdmembers_lt10yrs', null, array('class' => 'form-control', 'name'=>'inputHouseLessThan')) !!}
                {!! Form::text('ctr_householdmembers_gt10yrs', null, array('class' => 'form-control', 'name'=>'inputHouseGreaterThan')) !!}
                <!-- <input type="text" class="form-control digits" placeholder="< 10 yrs. old" name="inputHouseLessThan" id="inputHouseLessThan">
                <input type="text" class="form-control digits" placeholder=">= 10 yrs. old" name="inputHouseGreaterThan" id="inputHouseGreaterThan"> -->
            </div>
            <label class="col-sm-2 control-label">Family Folder</label>
            <div class="col-sm-4">
                <input type="text" class="form-control alphanumeric" name="family_folder_name" placeholder="Enter Last Name of the patient" value="">
            </div>
        </div>
        <hr />

        <div class="form-group">
            <label class="col-sm-2 control-label">Father status</label>
            <div class="col-sm-4">
                <div class="radio inline">
                    <label>
                      <input type="radio" name="inputFatherStatus[]" id="" value="alive" checked=""> Alive
                    </label>
                </div>
                <div class="radio inline">
                    <label>
                      <input type="radio" name="inputFatherStatus[]" id="" value="deceased" checked=""> Deceased
                    </label>
                </div>
            </div>

            <label class="col-sm-2 control-label">Mother status</label>
            <div class="col-sm-4">
                <div class="radio inline">
                    <label>
                      <input type="radio" name="inputMotherStatus[]" id="" value="alive" checked=""> Alive
                    </label>
                </div>
                <div class="radio inline">
                    <label>
                      <input type="radio" name="inputMotherStatus[]" id="" value="deceased" checked=""> Deceased
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Father's Firstname</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputFatherFirstName" value=""> -->
                        {!! Form::text('father_firstname', null, array('class' => 'form-control', 'name'=>'inputFatherFirstName')) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Father's Middlename</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputFatherMiddleName" value=""> -->
                        {!! Form::text('father_middlename', null, array('class' => 'form-control', 'name'=>'inputFatherMiddleName')) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Father's Lastname</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputFatherLastName" value=""> -->
                        {!! Form::text('last_name', null, array('class' => 'form-control', 'name'=>'inputFatherLastName')) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Suffix</label>
                    <div class="col-sm-8">
                        <div class="btn-group toggler" data-toggle="buttons">
                          <label class="btn btn-default">
                            <input type="radio" name="" id="" autocomplete="off"> Sr.
                          </label>
                          <label class="btn btn-default">
                            <input type="radio" name="" id="" autocomplete="off"> Jr.
                          </label>
                          <label class="btn btn-default">
                            <input type="radio" name="" id="" autocomplete="off"> III
                          </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Mother's Firstname</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputMotherFirstName" value=""> -->
                        {!! Form::text('father_alive', null, array('class' => 'form-control', 'name'=>'inputMotherFirstName')) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Mother's Middlename</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputMotherMiddleName" value=""> -->
                        {!! Form::text('father_alive', null, array('class' => 'form-control', 'name'=>'inputMotherMiddleName')) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label">Mother's Lastname</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" class="form-control alpha" placeholder="" name="inputMotherLastName" value=""> -->
                        {!! Form::text('father_alive', null, array('class' => 'form-control', 'name'=>'inputMotherLastName')) !!}
                    </div>
                </div>
            </div>
        </div>

    </fieldset>
    <fieldset>
        <legend>In Case of Emergency</legend>
        <div class="form-group has-feedback">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-4">
                <input type="text" class="form-control alpha" placeholder="Name of Contact" name="inputEmergencyName" value="">
            </div>

            <label class="col-sm-2 control-label">Relationship</label>
            <div class="col-sm-4">
                <select class="form-control" name="inputEmergencyRelationship">
                    <option value="">-- Select --</option>
                    <option>Father</option>
                    <option>Mother</option>
                    <option>Sibling</option>
                    <option>Spouse</option>
                    <option>Others</option>
                </select>
            </div>
            <label class="col-sm-2 control-label">Contact/Mobile No.</label>
            <div class="col-sm-4">
                <!-- <input type="text" class="form-control contact" placeholder="632-1234567 or 0917-1234567" name="inputEmergencyContact" value=""> -->
                {!! Form::text('father_alive', null, array('class' => 'form-control', 'name'=>'inputEmergencyContact')) !!}
            </div>

            <label class="col-sm-2 control-label">Address</label>
            <div class="col-sm-4">
                <textarea class="form-control alphanumeric" rows="5" name="inputEmergencyAddress"></textarea>
            </div>
        </div>
    </fieldset>
  </div><!-- /.tab-pane -->
