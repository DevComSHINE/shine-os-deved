<div class="tab-pane" id="philhealth">
    <fieldset>
        <legend>Health Benefits</legend>
        <div class="form-group">
            <label class="col-sm-2 control-label">PhilHealth</label>
            <div class="col-sm-1">
                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="PhilHealth" checked="" ="">
                      Yes
                    </label>
                </div>
            </div>
        </div>
    </fieldset>
    <!-- VIEW THIS IF PhilHealth == CHECKED -->
    <fieldset id="phicForm" class="">
        <legend> PhilHealth Membership Data </legend>
        <div class="form-group">
            <fieldset>
                <label class="col-sm-2 control-label">PhilHealth Member ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name=""  placeholder="" value="" >
                </div>
                <label class="col-sm-2 control-label">Pamilya Pantawid ID</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name=""  placeholder="" value="" >
                </div>
            </fieldset>
            <fieldset>
                <label class="col-sm-2 control-label">PhilHealth Member Type</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name=""  placeholder="" value="" >
                </div>
                <label class="col-sm-2 control-label">PhilHealth Member Category</label>
                <div class="col-sm-4">
                    <select class="form-control">
                        <option value="">-- Select a category --</option>
                        <option value="01">FE - Private - Permanent Regular</option>
                        <option value="02">FE - Private - Casual</option>
                        <option value="03">FE - Private - Contract/Project Based</option>
                        <option value="04">FE - Govt - Permanent Regular</option>
                        <option value="05">FE - Govt - Casual</option>
                        <option value="06">FE - Govt - Contract/Project Based</option>
                        <option value="07">FE - Enterprise Owner</option>
                        <option value="08">FE -Household Help/Kasambahay</option>
                        <option value="09">FE - Family Driver</option>
                        <option value="10">IE - Migrant Worker - Land Based</option>
                        <option value="11">IE - Migrant Worker - Sea Based</option>
                        <option value="12">IE - Informal Sector</option>
                        <option value="13">IE - Self Earning Individual</option>
                        <option value="14">IE - Filipino with Dual Citizenship</option>
                        <option value="15">IE - Naturalized Filipino Citizen</option>
                        <option value="16">IE - Citizen of other countries working/residing/studying in the Philippines</option>
                        <option value="17">IE - Organized Group</option>
                        <option value="18">Indigent - NHTS-PR</option>
                        <option value="19">Sponsored - LGU</option>
                        <option value="20">Sponsored - NGA</option>
                        <option value="21">Sponsored - Others</option>
                        <option value="22">Lifetime Member - Retiree/Pensioner</option>
                        <option value="23">Lifetime Member - With 120 months contribution and has reached retirement age</option>
                    </select>
                </div>
            </fieldset>
            <fieldset>
                <label class="col-sm-2 control-label">Conditional Cash Transfer</label>
                <div class="col-sm-4">
                    <div class="radio inline">
                        <label>
                          <input type="radio" name="ConditionalCashTransfer" id="" value="yes" checked="" =""> Yes
                        </label>
                    </div>
                    <div class="radio inline">
                        <label>
                          <input type="radio" name="ConditionalCashTransfer" id="" value="no" checked="" =""> No
                        </label>
                    </div>
                </div>
                <label class="col-sm-2 control-label">Indigenous Group</label>
                <div class="col-sm-4">
                    <div class="radio inline">
                        <label>
                          <input type="radio" name="IndigenousGroup" id="" value="yes" checked="" =""> Yes
                        </label>
                    </div>
                    <div class="radio inline">
                        <label>
                          <input type="radio" name="IndigenousGroup" id="" value="no" checked="" =""> No
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Benefit Package</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name=""  placeholder="" value="" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Apply for PhilHealth Membership</label>
            <div class="col-sm-10">
                <p> If patient is not yet a PhilHealth Member, you can fill-up an application form and send it to PHIE for submission to PhilHealth. Click the Apply Button to show the form now. </p>
            </div>
        </div>
    </fieldset>
</div><!-- /.tab-pane -->
