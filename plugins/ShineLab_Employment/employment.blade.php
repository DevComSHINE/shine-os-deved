
<?php
    $occupation = NULL;
    $company_phone = NULL;
    $company_name = NULL;
    $company_unitno = NULL;
    $company_address = NULL;
    $company_region = NULL;
    $company_province = NULL;
    $company_citymun = NULL;
    $company_barangay = NULL;
    $company_zip = NULL;
    $company_country = NULL;

    if($plugdata) {
        $employment = $plugdata;

        $occupation = $employment->occupation;
        $company_phone = $employment->company_phone;
        $company_name = $employment->company_name;
        $company_unitno = $employment->company_unitno;
        $company_address = $employment->company_address;
        $company_region = $employment->company_region;
        $company_province = $employment->company_province;
        $company_citymun = $employment->company_citymun;
        $company_barangay = $employment->company_barangay;
        $company_zip = $employment->company_zip;
        $company_country = $employment->company_country;
    }

    $method = 'save';
    if($plugdata) {
        $method = 'update';
    }
?>
<div class="tab-content">
<div id="employment" class="tab-pane step active">
    {!! Form::model($patient, array('url' => 'plugin/call/ShineLab_Employment/employment/'.$method.'/'.$patient->patient_id,'class'=>'form-horizontal')) !!}
    <fieldset>
        <input type="hidden" name="id" value="{{ $pluginData->id or NULL }}" />
        <input type="hidden" name="patient_id" value="{{ $patient->patient_id }}" />
        <legend>Employment Information</legend>
        <div class="form-group has-feedback">
            <label class="col-sm-2 control-label">Occupation/Position</label>
            <div class="col-sm-10">
                <input type="text" class="form-control aplha" placeholder="Occupation" name="occupation" value="{{ $occupation }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control aplha" placeholder="Company" name="company_name" value="{{ $company_name }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Phone</label>
            <div class="col-sm-4">
                <input type="text" class="form-control phonePH masked" name="company_phone"  placeholder="Company Phone Number" value="{{ $company_phone }}" data-mask="" data-inputmask="'mask': '99-9999999'" />
            </div>
        </div>
        <br clear="all" />
        <div class="form-group">
            <label class="col-sm-2 control-label">Office Unit No.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control alphanumeric" placeholder="Company" name="company_unitno" value="{{ $company_unitno }}" />
            </div>
            <label class="col-sm-2 control-label">Office Address</label>
            <div class="col-sm-4">
                <input type="text" class="form-control alphanumeric" placeholder="Office Address" name="company_address" value="{{ $company_address }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Region</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control required" name="region" id="region">
                    {{ Shine\Libraries\Utils::get_regions($company_region) }}
                </select>
            </div>

            <label class="col-sm-2 control-label">Province</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control required" name="province" id="province">
                    {{ Shine\Libraries\Utils::get_provinces($company_region, $company_province) }}
                </select>
            </div>

            <label class="col-sm-2 control-label">City / Municipality</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control required" name="city" id="city">
                    {{ Shine\Libraries\Utils::get_cities($company_region, $company_province, $company_citymun) }}
                </select>
            </div>

            <label class="col-sm-2 control-label">Barangay</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control required" name="brgy" id="brgy">
                    {{ Shine\Libraries\Utils::get_brgys($company_region, $company_province, $company_citymun, $company_barangay) }}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">ZIP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control digits" placeholder="ZIP Code" name="company_zip" value="{{ $company_zip }}" />
            </div>
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-4">
                <select class="populate placeholder form-control" name="company_country" id="company_country">
                    <option value="PHL">Philippines</option>
                </select>
            </div>
        </div>
    </fieldset>
    <div class="form-group pull-right ">
        <button type="button" class="btn btn-primary" onclick="location.href='{{ url('patients/view/'.$patient->patient_id) }}'">Close</button>
        <button type="submit" value="submit" class="btn btn-success">{{ ucfirst($method) }}</button>
    </div>
    {!! Form::close() !!}
    <br clear="all" />
</div>
</div>
