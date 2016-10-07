<div class="tab-pane step icheck" id="notifications">
    <fieldset class="col-md-12">
        <legend>Notification Settings</legend>
        <div class="form-group">
            <p>Check the box below to receive referral, appointment, and health announcements notification via SMS or email.</p>

            <div class="col-sm-12">
                <div class="checkbox-inline">
                    <label>
                        <input type="checkbox" value="1" name="inputBroadcastNotif" id="inputBroadcastNotif" @if(isset($patient) AND $patient->broadcast_notif == '1') checked='checked' @endif>
                        Receive Broadcast Notification
                    </label>
                </div>
                <div class="checkbox-inline" >
                    <label>
                        <input type="checkbox" value="1" name="inputReferralNotif" id="inputReferralNotif" @if(isset($patient) AND $patient->referral_notif == '1') checked='checked' @endif>
                        Receive Referral Notification
                    </label>
                </div>
                <div class="checkbox-inline">
                    <label>
                        <input type="checkbox" value="1" name="inputNonReferralNotif" id="inputNonReferralNotif" @if(isset($patient) AND $patient->nonreferral_notif == '1') checked='checked' @endif>
                        Receive Non-referral Notification
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="col-md-6">
        <legend>MyShine Account</legend>
        <div class="form-group">
            <p>MyShine is a client base access to personal health record. If client wants to sign up for MyShine, please check the box.</p>

            <div class="col-sm-12">
                <div class="checkbox-inline">
                    <label>
                        <input type="checkbox" value="1" name="inputMyShineAcct" id="inputMyShineAcct" @if(isset($patient) AND $patient->myshine_acct == '1') checked='checked' @endif>
                         MySHINE Access
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="col-md-6">
        <legend>Patient Consent</legend>
        <div class="form-group">
            <p>PHIE requires patients to sign a consent form. Once signed, check the box below and click 'Submit' to complete the record. If patient does not aggree or does not want to share his/her information through PHIE, do not check the box</p>

            <div class="col-sm-12">
                <div class="checkbox-inline">
                    <label>
                      <input type="checkbox" value="1" name="inputPatientConsent" id="inputPatientConsent" @if(isset($patient) AND $patient->patient_consent == '1') checked='checked' @endif>
                       Patient Consent
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <input type="hidden" name="record_status" value='1' />

    <br clear="all" />

</div><!-- /.tab-pane -->
