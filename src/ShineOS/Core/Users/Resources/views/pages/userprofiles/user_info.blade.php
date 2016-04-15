<h4>User Information</h4>
<!-- form start -->
{!! Form::open(array( 'url'=>$modulePath.'/updateinfo/'.$userInfo->user_id, 'id'=>'UserInformationForm', 'name'=>'UserInformationForm', 'class'=>'form-horizontal' )) !!}
    <div class="box-body">
        <div class="form-group">
            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $userInfo->last_name }}" required />
            </div>
        </div>
        <div class="form-group">
            <label for="first_name" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $userInfo->first_name }}" required />
            </div>
        </div>
        <div class="form-group">
            <label for="middle_name" class="col-sm-2 control-label">Middle Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ $userInfo->middle_name }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="suffix_name" class="col-sm-2 control-label">Suffix Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="suffix_name" name="suffix_name" placeholder="Suffix Name" value="{{ $userInfo->suffix }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="birth_date" class="col-sm-2 control-label">Birthday</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="datepicker" name="birth_date" placeholder="Birthday" value="{{ date("m/d/Y", strtotime($userInfo->birth_date)) }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email Address</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $userInfo->email }}" disabled="disabled" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Home Number</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Home Number" value="{{ $userContact->phone }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="col-sm-2 control-label">Mobile Number</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ $userContact->mobile }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="house_no" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="house_no" name="house_no" placeholder="House No." value="{{ $userContact->house_no }}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Building Name" value="{{ $userContact->building_name }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Street Name" value="{{ $userContact->street_name }}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="village" name="village" placeholder="Village" value="{{ $userContact->village }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <select class="placeholder form-control required" name="region" id="region">
                    {{ Shine\Libraries\Utils::get_regions($userContact->region) }}
                </select>
            </div>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="province" id="province">
                    {{ Shine\Libraries\Utils::get_provinces($userContact->region, $userContact->province) }}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="city" id="city">
                    {{ Shine\Libraries\Utils::get_cities($userContact->region, $userContact->province, $userContact->city) }}
                </select>
            </div>
            <div class="col-sm-5">
                <select class="populate placeholder form-control required" name="brgy" id="brgy">
                    {{ Shine\Libraries\Utils::get_brgys($userContact->region, $userContact->province, $userContact->city, $userContact->barangay) }}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="zip" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP" value="{{ $userContact->zip }}" />
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="{{ $userContact->country }}" />
            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
    <button type="submit" class="btn btn-success pull-right">Update Info</button>
    </div><!-- /.box-footer -->
{!! Form::close() !!}
