<h4>User Information</h4>
<!-- form start -->
{!! Form::open(array( 'url'=>$modulePath.'/updateinfo/'.$userInfo->user_id, 'id'=>'UserInformationForm', 'name'=>'UserInformationForm', 'class'=>'form-horizontal' )) !!}
    <div class="box-body">
        <div class="form-group">
            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $userInfo->last_name or NULL }}" required />
            </div>
        </div>
        <div class="form-group">
            <label for="first_name" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $userInfo->first_name or NULL }}" required />
            </div>
        </div>
        <div class="form-group">
            <label for="middle_name" class="col-sm-2 control-label">Middle Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ $userInfo->middle_name or NULL }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="suffix_name" class="col-sm-2 control-label">Suffix Name</label>
            <div class="col-sm-10">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default @if(isset($userInfo) AND $userInfo->suffix == 'Sr') active @endif">
                    <i class="fa fa-check"></i> <input type="radio" name="suffix_name" id="" autocomplete="off" value="Sr"> Sr.
                  </label>
                  <label class="btn btn-default @if(isset($userInfo) AND $userInfo->suffix == 'Jr') active @endif">
                    <i class="fa fa-check"></i> <input type="radio" name="suffix_name" id="" autocomplete="off" value="Jr"> Jr.
                  </label>
                  <label class="btn btn-default @if(isset($userInfo) AND $userInfo->suffix == 'third') active @endif">
                    <i class="fa fa-check"></i> <input type="radio" name="suffix_name" id="" autocomplete="off" value="third"> III
                  </label>
                  <label class="btn btn-default">
                    <i class="fa fa-check"></i> <input type="radio" name="suffix_name" id="" autocomplete="off" value=""> None
                  </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="suffix_name" class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-10">
                <div class="btn-group toggler" data-toggle="buttons">
                  <?php
                    $genderm = false; $genderf = false; $genderu = false;
                    if(isset($userInfo) AND $userInfo->gender == "M") $genderm = true;
                    if(isset($userInfo) AND $userInfo->gender == "F") $genderf = true;
                    if(isset($userInfo) AND $userInfo->gender == "U") $genderu = true;
                    if(isset($userInfo) AND $userInfo->gender == "") $genderu = true;
                  ?>
                  <label class="btn btn-default required @if(isset($userInfo) AND $userInfo->gender=='M') active @endif">
                    <i class="fa fa-check"></i> {!! Form::radio('usergender', 'M', $genderm, array('class' => 'form-control gender', 'required'=>'required')) !!} Male
                  </label>
                  <label class="btn btn-default required @if(isset($userInfo) AND $userInfo->gender=='F') active @endif">
                    <i class="fa fa-check"></i> {!! Form::radio('usergender', 'F', $genderf, array('class' => 'form-control gender', 'required'=>'required')) !!} Female
                  </label>
                  @if($genderu)
                  <label class="btn btn-default required @if(isset($userInfo) AND isset($patient) AND ($userInfo->gender=='U' OR $patient->gender=='')) active  @endif">
                    <i class="fa fa-check"></i> {!! Form::radio('usergender', 'U', $genderu, array('class' => 'form-control gender', 'required'=>'required')) !!} Unknown
                  </label>
                  @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="birth_date" class="col-sm-2 control-label">Birthday</label>
            <div class="col-sm-10">

                {!! Form::text('birth_date', date("m/d/Y", strtotime($userInfo->birth_date)), array('id' => '', 'class' => 'form-control datepicker_null')) !!}

            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email Address</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $userInfo->email or NULL }}" disabled="disabled" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Home Number</label>
            <div class="col-sm-10">
                {!! Form::text('phone', $userContact->phone, array('class' => 'form-control phonePH masked', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;99-9999999&quot;', 'placeholder'=>'02-5772886')) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="col-sm-2 control-label">Mobile Number</label>
            <div class="col-sm-10">
                {!! Form::text('mobile', $userContact->mobile, array('class' => 'form-control mobilePH masked', 'data-mask'=>'', 'data-inputmask'=>'&quot;mask&quot;: &quot;0999-9999999&quot;', 'placeholder'=>'0917-1234567')) !!}
            </div>
        </div>
        <div class="form-group">
            <label for="house_no" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="house_no" name="house_no" placeholder="House No." value="{{ $userContact->house_no or NULL }}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Building Name" value="{{ $userContact->building_name or NULL }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Street Name" value="{{ $userContact->street_name or NULL }}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="village" name="village" placeholder="Village" value="{{ $userContact->village or NULL }}" />
            </div>
        </div>
        <?php
        $region = NULL;
        $province = NULL;
        $city = NULL;
        $brgy = NULL;
        $zip = NULL;

        if($userContact) {
            $region = $userContact->region;
            $province = $userContact->province;
            $city = $userContact->city;
            $brgy = $userContact->barangay;
        }
        
        ?>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <select class="placeholder form-control required" name="region" id="region">
                    {{ Shine\Libraries\Utils::get_regions($region) }}
                </select>
            </div>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="province" id="province">
                    {{ Shine\Libraries\Utils::get_provinces($region, $province) }}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="city" id="city">
                    {{ Shine\Libraries\Utils::get_cities($region, $province, $city) }}
                </select>
            </div>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="brgy" id="brgy">
                    {{ Shine\Libraries\Utils::get_brgys($region, $province, $city, $brgy) }}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="zip" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP" value="{{ $userContact->zip or NULL}}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="{{ $userContact->country or NULL }}" />
            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
    <button type="submit" class="btn btn-success pull-right">Update Info</button>
    </div><!-- /.box-footer -->
{!! Form::close() !!}
