<div class="tab-pane step" id="personal">
    <fieldset>
        <legend>Personal Information</legend>

        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">Suffix</label>
                <div class="col-sm-4">
                    <div class="btn-group toggler" data-toggle="buttons">
                      <label class="btn btn-default @if(isset($patient) AND $patient->suffix == 'Sr') active @endif">
                        <i class="fa fa-check"></i> <input type="radio" name="inputPatientSuffix" id="" autocomplete="off" value="Sr"> Sr.
                      </label>
                      <label class="btn btn-default @if(isset($patient) AND $patient->suffix == 'Jr') active @endif">
                        <i class="fa fa-check"></i> <input type="radio" name="inputPatientSuffix" id="" autocomplete="off" value="Jr"> Jr.
                      </label>
                      <label class="btn btn-default @if(isset($patient) AND $patient->suffix == 'third') active @endif">
                        <i class="fa fa-check"></i> <input type="radio" name="inputPatientSuffix" id="" autocomplete="off" value="third"> III
                      </label>
                      <label class="btn btn-default">
                        <i class="fa fa-check"></i> <input type="radio" name="inputPatientSuffix" id="" autocomplete="off" value=""> None
                      </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Gender *</label>
                <div class="col-sm-4">
                    <div class="btn-group toggler" data-toggle="buttons">
                      <?php
                        $genderm = false; $genderf = false; $genderu = false;
                        if(isset($patient) AND $patient->gender == "M") $genderm = true;
                        if(isset($patient) AND $patient->gender == "F") $genderf = true;
                        if(isset($patient) AND $patient->gender == "U") $genderu = true;
                      ?>
                      <label class="btn btn-default required @if(isset($patient) AND $patient->gender=='M') active @endif">
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'M', $genderm, array('class' => 'gender required')) !!} Male
                      </label>
                      <label class="btn btn-default required @if(isset($patient) AND $patient->gender=='F') active @endif">
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'F', $genderf, array('class' => 'gender required')) !!} Female
                      </label>
                      @if($genderu)
                      <label class="btn btn-default required @if(isset($patient) AND $patient->gender=='U') active @endif">
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'U', $genderu, array('class' => 'gender required')) !!} Unknown
                      </label>
                      @endif
                    </div>
                </div>
                <label class="col-sm-2 control-label" for="marital_status">Marital Status *</label>
                <div class="col-sm-4">
                    <select class="required form-control" name="inputPatientStatus" id="marital_status_field" onchange="show_maiden()">
                        <option value="">- Select civil status -</option>
                        <option value="S" @if(isset($patient) AND $patient->gender == 'S') selected='selected' @endif >Single</option>
                        <option value="M" @if(isset($patient) AND $patient->gender == 'M') selected='selected' @endif >Married</option>
                        <option value="X" @if(isset($patient) AND $patient->gender == 'X') selected='selected' @endif >Separated</option>
                        <option value="A" @if(isset($patient) AND $patient->gender == 'A') selected='selected' @endif >Annuled</option>
                        <option value="W" @if(isset($patient) AND $patient->gender == 'W') selected='selected' @endif >Widower</option>
                    </select>
                </div>
            </div>
            <div class="form-group maiden">
                <label class="col-sm-2 control-label">Maiden Last Name </label>
                <div class="col-sm-4">
                    {!! Form::text('maiden_lastname', null, array('class' => 'form-control', 'name'=>'inputMaidenLastName')) !!}
                </div>

                <label class="col-sm-2 control-label">Maiden Middle Name </label>
                <div class="col-sm-4">
                    {!! Form::text('maiden_middlename', null, array('class' => 'form-control', 'name'=>'inputMaidenMiddleName')) !!}
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend></legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">Place of Birth</label>
                <div class="col-sm-4">
                    {!! Form::text('birthplace', null, array('class' => 'form-control', 'name'=>'inputPatientBirthPlace')) !!}
                </div>
                <label class="col-sm-2 control-label">Time of Birth</label>
                <div class="col-sm-4 iconed-input bootstrap-timepicker">
                    <i class="fa fa-clock-o inner-icon"></i>
                    {!! Form::text('birthtime', null, array('class' => 'form-control timepicker', 'name'=>'inputPatientBirthTime','id'=>'')) !!}
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend></legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">Religion</label>
                <div class="col-sm-4">
                    <select class="populate placeholder form-control" name="inputPatientReligion" id="inputPatientReligion" onchange="if(this.value == 'OTHER') { $('#religionother').removeClass('hidden'); } else { $('#religionother').addClass('hidden'); }">
                        <option value="">- Select religion -</option>
                        @foreach ($religion as $key=>$val)
                            <option value='{{ $key }}' @if(isset($patient) AND $patient->religion == $key) selected='selected' @endif >{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="religionother" class="hidden">
                    <label class="col-sm-2 control-label">Specify Religion</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="inputPatientOtherReligion" placeholder="Other Religion" value="{{{ isset($patient->religion_others) ? $patient->religion_others : '' }}}"  />
                    </div>
                </div>
            </div>
            <div class="form-group">

                <label class="col-sm-2 control-label" for="education">Highest Education</label>
                <div class="col-sm-4">
                    <select class="form-control" name="inputPatientEducation" id="inputPatientEducation" onchange="if(this.value == '99') { $('#educother').removeClass('hidden'); } else { $('#educother').addClass('hidden'); }">
                        <option value="">- Select education -</option>
                        <option value='01' @if(isset($patient) AND $patient->education == '01') selected='selected' @endif >Elementary Education</option>
                        <option value='02' @if(isset($patient) AND $patient->education == '02') selected='selected' @endif >High School Education</option>
                        <option value='03' @if(isset($patient) AND $patient->education == '03') selected='selected' @endif >College</option>
                        <option value='04' @if(isset($patient) AND $patient->education == '04') selected='selected' @endif >Postgraduate Program</option>
                        <option value='05' @if(isset($patient) AND $patient->education == '05') selected='selected' @endif >No Formal Education/No Schooling</option>
                        <option value='06' @if(isset($patient) AND $patient->education == '06') selected='selected' @endif >Not Applicable</option>
                        <option value='07' @if(isset($patient) AND $patient->education == '07') selected='selected' @endif >Vocational</option>
                        <option value='99' @if(isset($patient) AND $patient->education == '99') selected='selected' @endif >Others</option>
                    </select>
                </div>
                <div id="educother" class="hidden">
                    <label class="col-sm-2 control-label">Specify Education</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="inputPatientEducationOther" placeholder="Other Education" value="{{{ isset($patient->highesteducation_others) ? $patient->highesteducation_others : '' }}}"  />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nationality</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control alpha" name="inputPatientNationality" value="{{{ isset($patient->nationality) ? $patient->nationality : '' }}}"  />
                </div>
            </div>

        </fieldset>
    </fieldset>
</div><!-- /.tab-pane -->

@section('footer')
<script>

        function show_maiden()
        {
            var marital_status = $("#marital_status_field").val();
            var gender = $(".gender:checked").val();

            console.log(gender);
            if (marital_status == 'M')
            {
                $('.maiden').show();
            }
            else
            {
                $('.maiden').hide();
            }
        }

</script>
@stop
