<div class="tab-pane active step" id="basic">
    <style>
        .maiden { display: none;}
    </style>

    <fieldset>
        <legend>Basic Record Information</legend>
        <div class="text-group">
            <p>Complete filling up the mandatory fields to proceed. Mandatory fields include an asterisk (*). If the information you entered here already exist, you will be notified.</p>
        </div>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">First name *</label>
                <div class="col-sm-4">
                    {!! Form::text('first_name', null, array('class' => 'form-control required', 'name'=>'inputPatientFirstName') ) !!}
                </div>
                <label class="col-sm-2 control-label">Last name *</label>
                <div class="col-sm-4">
                    {!! Form::text('last_name', null, array('class' => 'form-control required', 'name'=>'inputPatientLastName')) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Middle name *</label>
                <div class="col-sm-4">
                    {!! Form::text('middle_name', null, array('class' => 'form-control required', 'name'=>'inputPatientMiddleName')) !!}
                </div>
                <label class="col-sm-2 control-label">Birth Date *</label>
                <div class="col-sm-4">
                    {!! Form::text('birthdate', null, array('class' => 'form-control required datepicker_null', 'name'=>'inputPatientBirthDate')) !!}
                </div>

            </div>
        </fieldset>
    </fieldset>

    <fieldset>
        <div id="results" class="hidden opac-yellow black"></div>
    </fieldset>

</div><!-- /.tab-pane -->
