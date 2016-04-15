@section('heads')
{!! HTML::style('public/dist/js/prettify.css') !!}
{!! HTML::style('plugins/datepicker/datepicker3.css') !!}
{!! HTML::style('plugins/timepicker/bootstrap-timepicker.min.css') !!}
@stop

<style>
.maiden { display: none;}
</style>

<div class="tab-pane active" id="basic">
    <fieldset>
        <legend>Basic Record Information</legend>
        <!-- <div class="text-group">
            <p>Complete the following fields then click Next. If the information you entered here already existing, you will be notified.</p>
        </div> -->

        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">First name </label>
                <div class="col-sm-4">
                    {!! Form::text('first_name', null, array('class' => 'form-control', 'name'=>'inputPatientFirstName')) !!}
                </div>
                <label class="col-sm-2 control-label">Middle name </label>
                <div class="col-sm-4">
                    {!! Form::text('middle_name', null, array('class' => 'form-control', 'name'=>'inputPatientMiddleName')) !!}
                </div>
                <label class="col-sm-2 control-label">Last name </label>
                <div class="col-sm-4">
                    {!! Form::text('last_name', null, array('class' => 'form-control', 'name'=>'inputPatientLastName')) !!}
                </div>

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
                    </div>
                </div>

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
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'M', $genderm, array('class' => 'form-control gender')) !!} Male
                      </label>
                      <label class="btn btn-default required @if(isset($patient) AND $patient->gender=='F') active @endif">
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'F', $genderf, array('class' => 'form-control gender')) !!} Female
                      </label>
                      <label class="btn btn-default required @if(isset($patient) AND $patient->gender=='U') active @endif">
                        <i class="fa fa-check"></i> {!! Form::radio('inputPatientGender', 'U', $genderu, array('class' => 'form-control gender')) !!} Unknown
                      </label>
                    </div>
                </div>

                <label class="col-sm-2 control-label" for="marital_status">Marital Status *</label>
                <div class="col-sm-4">
                    <select class="required form-control" name="inputPatientStatus" id="marital_status_field" onchange="show_maiden();">
                        <option value="">- Select civil status -</option>
                        <option value="S" @if(isset($patient) AND $patient->civil_status == 'S') selected='selected' @endif >Single</option>
                        <option value="M" @if(isset($patient) AND $patient->civil_status == 'M') selected='selected' @endif >Married</option>
                        <option value="X" @if(isset($patient) AND $patient->civil_status == 'X') selected='selected' @endif >Separated</option>
                        <option value="A" @if(isset($patient) AND $patient->civil_status == 'A') selected='selected' @endif >Annuled</option>
                        <option value="W" @if(isset($patient) AND $patient->civil_status == 'W') selected='selected' @endif >Widower</option>
                    </select>
                </div>

                <?php
                $hide = 'hidden';
                if(isset($patient) AND isset($patient) AND $genderf == true AND $patient->civil_status == 'M') {
                    $hide = '';
                } ?>
                <div class="maiden {{ $hide }}">
                    <label class="col-sm-2 control-label">Maiden Last Name </label>
                    <div class="col-sm-4">
                        {!! Form::text('maiden_lastname', null, array('class' => 'form-control', 'name'=>'inputMaidenLastName')) !!}
                    </div>

                    <label class="col-sm-2 control-label">Maiden Middle Name </label>
                    <div class="col-sm-4">
                        {!! Form::text('maiden_middlename', null, array('class' => 'form-control', 'name'=>'inputMaidenMiddleName')) !!}
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend></legend>
            <div class="form-group">
                <label class="col-sm-2 control-label">Birth Date *</label>
                <div class="col-sm-4 iconed-input">
                    <i class="fa fa-calendar inner-icon"></i>
                    {!! Form::text('birthdate', date("m/d/Y", strtotime($patient->birthdate)), array('id' => 'datepicker', 'class' => 'form-control', 'name'=>'inputPatientBirthDate')) !!}
                </div>
                <label class="col-sm-2 control-label">Age</label>
                <div class="col-sm-4">
                    {!! Form::text('age', getAge($patient->birthdate), array('class' => 'form-control', 'readonly'=>'readonly')) !!}
                </div>
                <label class="col-sm-2 control-label">Time of Birth</label>
                <div class="col-sm-4 bootstrap-timepicker timepicker iconed-input">
                    <i class="fa fa-clock-o inner-icon"></i>
                    {!! Form::text('birthtime', date("h:i A", strtotime($patient->birthtime)), array('id' => 'timepicker', 'class' => 'form-control input-small', 'name'=>'inputPatientBirthTime')) !!}
                </div>
                <label class="col-sm-2 control-label">Place of Birth</label>
                <div class="col-sm-4">
                    {!! Form::text('birthplace', null, array('class' => 'form-control', 'name'=>'inputPatientBirthPlace')) !!}
                </div>

            </div>
        </fieldset>
        <fieldset>
            <legend></legend>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="col-sm-4 control-label">Religion</label>
                    <div class="col-sm-8">
                        <select class="populate placeholder form-control" name="inputPatientReligion" id="inputPatientReligion" onchange="if(this.value == 'OTHER') { $('#religionother').removeClass('hidden'); } else { $('#religionother').addClass('hidden'); }">
                            <option value="">- Select religion -</option>
                            @foreach ($religion as $key=>$val)
                                <option value='{{ $key }}' @if(isset($patient) AND $patient->religion == $key) selected='selected' @endif >{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="religionother" class="hidden">
                        <label class="col-sm-4 control-label">Specify Religion</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="inputPatientOtherReligion" placeholder="Other Religion" value="{{{ isset($patient->religion_others) ? $patient->religion_others : '' }}}"  />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="col-sm-4 control-label" for="education">Highest Education</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="inputPatientEducation" id="inputPatientEducation" onchange="if(this.value == '99') { $('#educother').removeClass('hidden'); } else { $('#educother').addClass('hidden'); }">
                            <option value="" @if(!isset($patient)) selected='selected' @endif>- Select education -</option>
                            <option value='01' @if(isset($patient) AND $patient->highest_education == '01') selected='selected' @endif >Elementary Education</option>
                            <option value='02' @if(isset($patient) AND $patient->highest_education == '02') selected='selected' @endif >High School Education</option>
                            <option value='03' @if(isset($patient) AND $patient->highest_education == '03') selected='selected' @endif >College</option>
                            <option value='04' @if(isset($patient) AND $patient->highest_education == '04') selected='selected' @endif >Postgraduate Program</option>
                            <option value='05' @if(isset($patient) AND $patient->highest_education == '05') selected='selected' @endif >No Formal Education/No Schooling</option>
                            <option value='06' @if(isset($patient) AND $patient->highest_education == '06') selected='selected' @endif >Not Applicable</option>
                            <option value='07' @if(isset($patient) AND $patient->highest_education == '07') selected='selected' @endif >Vocational</option>
                            <option value='99' @if(isset($patient) AND $patient->highest_education == '99') selected='selected' @endif >Others</option>
                        </select>
                    </div>
                    <div id="educother" class="hidden">
                        <label class="col-sm-4 control-label">Specify Education</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="inputPatientEducationOther" placeholder="Other Education" value="{{{ isset($patient->highesteducation_others) ? $patient->highesteducation_others : '' }}}"  />
                        </div>
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
