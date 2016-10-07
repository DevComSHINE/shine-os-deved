<?php
$phone = NULL;
$phone_ext = NULL;
$mobile = NULL;
$email = NULL;
$street_address = NULL;
$region = NULL;
$province = NULL;
$city = NULL;
$barangay = NULL;
$zip = NULL;
$country = NULL;
$emergency_name = NULL;
$emergency_relationship = NULL;
$emergency_phone = NULL;
$emergency_mobile = NULL;
$emergency_address = NULL;
$email_editable = "";

if($facility) {
    $region = $facility->facilityContact->region;
    $province = $facility->facilityContact->province;
    $city = $facility->facilityContact->city;
    $barangay = $facility->facilityContact->barangay;
}

if(isset($patient)) {
    if($patient->patientContact){
        $phone = $patient->patientContact->phone;
        $phone_ext = $patient->patientContact->phone_ext;
        $mobile = $patient->patientContact->mobile;
        $email = $patient->email;
        $password = $patient->password;
        $street_address = $patient->patientContact->street_address;
        $region = $patient->patientContact->region;
        $province = $patient->patientContact->province;
        $city = $patient->patientContact->city;
        $barangay = $patient->patientContact->barangay;
        $zip = ($patient->patientContact->zip > 0) ? $patient->patientContact->zip : NULL;
        $country = $patient->patientContact->country;
    }
    if($patient->patientEmergencyInfo){
        $emergency_name = $patient->patientEmergencyInfo->emergency_name;
        $emergency_relationship = $patient->patientEmergencyInfo->emergency_relationship;
        $emergency_phone = $patient->patientEmergencyInfo->emergency_phone;
        $emergency_mobile = $patient->patientEmergencyInfo->emergency_mobile;
        $emergency_address = $patient->patientEmergencyInfo->emergency_address;
    }
}
?>

<div class="tab-pane step" id="location">
    <fieldset>
        <legend>Contact Data</legend>
        <div class="form-group">
            <label class="col-sm-2 control-label">Phone number</label>
            <div class="col-sm-4">
                {!! Form::text('phone', $phone, array('class' => 'form-control phonePH masked', 'name'=>'inputPatientPhone', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;99-9999999&quot;', 'placeholder'=>'02-5772886')) !!}
            </div>
            <label class="col-sm-2 control-label">Phone extension</label>
            <div class="col-sm-4">
                {!! Form::text('phone_ext', $phone_ext, array('class' => 'form-control digits', 'name'=>'inputPatientPhoneExtension')) !!}
            </div>
            <label class="col-sm-2 control-label">Mobile number</label>
            <div class="col-sm-4">
                {!! Form::text('mobile', $mobile, array('class' => 'form-control mobilePH masked', 'name'=>'inputPatientMobile', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;0999-9999999&quot;', 'placeholder'=>'0917-1234567')) !!}
            </div>
            <label class="col-sm-2 control-label">Email address</label>
            <div class="col-sm-4">
                @if(isset($patient))
                    @if($password!=NULL AND $email!=NULL)
                        <?php $email_editable = "disabled"; ?>
                    @endif
                @endif
                {!! Form::text('email', $email, array('class' => 'form-control email', 'name'=>'inputPatientEmail', $email_editable=>"")) !!}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Address Information</legend>
        <div class="form-group col-md-12">
            <div class="row">
                <label class="col-sm-2 control-label">Street Address</label>
                <div class="col-sm-4">
                    {!! Form::text('street_address', $street_address, array('class' => 'form-control alpha', 'name'=>'inputPatientAddress')) !!}
                </div>
                <br clear="all" />
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="row">
                <label class="col-sm-4 control-label">Region</label>
                <div class="col-sm-8">
                    <select class="placeholder form-control required" name="region" id="region" required='required'>
                        {{ Shine\Libraries\Utils::get_regions($region) }}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="row">
                <label class="col-sm-4 control-label">Province</label>
                <div class="col-sm-8">
                    <select class="populate placeholder form-control required" name="province" id="province" required='required'>
                        {{ Shine\Libraries\Utils::get_provinces($region, $province) }}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="row">
                <label class="col-sm-4 control-label">City / Municipality</label>
                <div class="col-sm-8">
                    <select class="populate placeholder form-control required" name="city" id="city" required='required'>
                        {{ Shine\Libraries\Utils::get_cities($region, $province, $city) }}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="row">
                <label class="col-sm-4 control-label">Barangay</label>
                <div class="col-sm-8">
                    <select class="populate placeholder form-control required" name="brgy" id="brgy" required='required'>
                        {{ Shine\Libraries\Utils::get_brgys($region, $province, $city, $barangay) }}
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="row">
                <label class="col-sm-2 control-label">ZIP</label>
                <div class="col-sm-4">
                    {!! Form::text('zip', $zip, array('class' => 'form-control', 'name'=>'inputPatientZip')) !!}
                </div>
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-4">
                    <select class="populate placeholder form-control" name="inputPatientCountry" id="country">
                        <option value="PHL">Philippines</option>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>In Case of Emergency</legend>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control alpha" placeholder="Name of Contact" name="emergency_name" value="{{ $emergency_name }}">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label">Relationship</label>
                <div class="col-sm-8">
                    <select class="form-control" name="emergency_relationship">
                        <option value="">-- Select --</option>
                        <option <?php if($emergency_relationship == 'Father') echo "selected"; ?>>Father</option>
                        <option <?php if($emergency_relationship == 'Mother') echo "selected"; ?>>Mother</option>
                        <option <?php if($emergency_relationship == 'Sibling') echo "selected"; ?>>Sibling</option>
                        <option <?php if($emergency_relationship == 'Spouse') echo "selected"; ?>>Spouse</option>
                        <option <?php if($emergency_relationship == 'Others') echo "selected"; ?>>Others</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label">Phone</label>
                <div class="col-sm-8">
                    {!! Form::text('emergency_phone', $emergency_phone, array('class' => 'form-control phonePH masked', 'name'=>'emergency_phone', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;99-9999999&quot;', 'placeholder'=>'02-5772886')) !!}
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label">Mobile</label>
                <div class="col-sm-8">
                    {!! Form::text('emergency_mobile', $emergency_mobile, array('class' => 'form-control mobilePH masked', 'name'=>'emergency_mobile', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;0999-9999999&quot;', 'placeholder'=>'0917-1234567')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label">Address</label>
                <div class="col-sm-8">
                    <textarea class="form-control alphanumeric" rows="5" name="emergency_address">{{ $emergency_address }}</textarea>
                </div>
            </div>
        </div>
    </fieldset>
</div><!-- /.tab-pane -->
