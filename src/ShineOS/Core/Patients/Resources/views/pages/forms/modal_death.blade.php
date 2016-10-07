<?php
 $disable = NULL; $patid = NULL;
 $formTitle = "Declare Patient Dead";
 if(isset($deathInfo)){
     $disable = 'disabled';
     $formTitle = "Patient Death Information";
 }
 if(isset($patient_id)){
     $patid = $patient_id;
}
?>

<div class="modal-header bg-blue-gradient">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myInfoModalLabel"> {{ $formTitle }} </h4>
</div>
<div class="modal-body">
<!-- Modal form-->
        {!! Form::open(array('url' => 'patients/saveDeathInfo','class'=>'form-horizontal', 'method'=>'PATCH')) !!}
        <fieldset {{ $disable }}>
            <input type="hidden" name="patient_id" id="patient_id" value="{{ $patid }}"/>
            <div class="modal-body" id="modal-body">
              <div class="form-group">
                <label for="inputDeathCertificate">Death Certificate File <small>(if any)</small></label>
                @if(isset($deathInfo) AND $deathInfo->DeathCertificate_Filename)
                <a href="#" target="_blank">View Certificate</a>
                @else
                <input type="file" id="inputDeathCertificate" name="inputDeathCertificate">
                @endif
              </div>
              <div class="form-group">
                <label for="DeathCertificateNo">Death Certificate Number</label>
                <input type="text" class="form-control" name="DeathCertificateNo" id="DeathCertificateNo" placeholder="Death Certificate Number" value="@if( isset($deathInfo) AND $deathInfo->DeathCertificateNo) {{ $deathInfo->DeathCertificateNo }} @endif" />
              </div>
              <div class="form-group">
                <label for="inputDateTimeDeath">Date and Time of Death</label>
                <input type="text" class="form-control datetimepicker_past required" name="inputDateTimeDeath" id="" placeholder="Death Time and Day" value="@if(isset($deathInfo) AND $deathInfo->datetime_death) {{ date('m/d/Y h:i A', strtotime($deathInfo->datetime_death)) }} @else {{ date('m/d/Y h:i A') }} @endif" required="required">
              </div>
              <div class="form-group">
                <label for="Immediate_Cause_of_Death">Immediate Cause of Death</label>
                <input type="text" class="form-control required" name="Immediate_Cause_of_Death" id="Immediate_Cause_of_Death" placeholder="Disease, injury or complication that led directly to death" required="required" value="@if( isset($deathInfo) AND $deathInfo->Immediate_Cause_of_Death) {{ $deathInfo->Immediate_Cause_of_Death }} @endif">
              </div>
              <div class="form-group">
                <label for="Antecedent_Cause_of_Death">Antecedent Cause of Death</label>
                <input type="text" class="form-control required" name="Antecedent_Cause_of_Death" id="Antecedent_Cause_of_Death" placeholder="Conditions giving rise to the immediate cause of death" required="required" value="@if( isset($deathInfo) AND $deathInfo->Antecedent_Cause_of_Death) {{ $deathInfo->Antecedent_Cause_of_Death }} @endif">
              </div>
              <div class="form-group">
                <label for="Underlying_Cause_of_Death">Underlying Cause of Death</label>
                <input type="text" class="form-control required" name="Underlying_Cause_of_Death" id="Underlying_Cause_of_Death" placeholder="Disease or injury that initiated the train of events leading directly to death" required="required" value="@if( isset($deathInfo) AND $deathInfo->Underlying_Cause_of_Death) {{ $deathInfo->Underlying_Cause_of_Death }} @endif">
              </div>
              <div class="form-group">
                <label for="deathPlaceType">Place of Death</label>
                <div>
                <?php
                    $DPT = NULL;
                    if( isset($deathInfo) AND $deathInfo->PlaceDeath) {
                        $DPT = $deathInfo->PlaceDeath;
                    }
                ?>
                  {!! Form::select('deathPlaceType',
                  array(NULL =>'--Select--',
                        'NID' => 'Non-Institutional Death',
                        'FB' => 'Facility-Based'),
                  $DPT, ['class' => 'form-control required', 'id' => 'deliveryPlace_select', 'required'=>'required']) !!}
                </div>
              </div>
              <?php
                    $sDPFB = $dPH = $sDPNID = 'hidden';
                    $DPTFB = NULL;
                    if( isset($deathInfo) AND $deathInfo->PlaceDeath_FacilityBased) {
                        $DPTFB = $deathInfo->PlaceDeath_FacilityBased;
                    }
                    $DPTNID = NULL;
                    if( isset($deathInfo) AND $deathInfo->PlaceDeath_NID) {
                        $DPTNID = $deathInfo->PlaceDeath_NID;
                    }
                    if($DPT) $dPH = '';
                    if($DPT == 'FB') $sDPFB = '';
                    if($DPT == 'NID') $sDPNID = '';
                ?>
              <div class="form-group">
                <div id="deliveryPlaceHead" class="{{ $dPH }}">
                  <div class="form-group">
                    <div>
                        {!!Form::select('deathplace_FB',
                        array(  NULL =>'--Select--',
                                'bhs' => 'Barangay Health Station',
                                'rhu' => 'Rural Health Unit',
                                'hp'  => 'Hospital',
                                'LBC' => 'Lying-in / Birthing Clinics',
                                'pc'  => 'Private Clinic'),
                        $DPTFB, ['class' => 'form-control '.$sDPFB, 'id' => 'deliveryplace_FB']) !!}

                        {!!Form::select('deathplace_NID',
                        array(  NULL =>'--Select--',
                                'hme' => 'Home',
                                'hsp' => 'In Transit',
                                'oth' => 'Others'),
                        $DPTNID, ['class' => 'form-control '.$sDPNID, 'id' => 'deliveryplace_NID']) !!}
                    </div>
                    <div id="nidOthersSpecifiy" class="hidden">
                        {!!Form::text('deathplace_NID_Others', '', ['class' => 'form-control', 'id' => 'deathplace_NID_Others', 'placeholder' => 'Specify place of death']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <?php
                $ToD = NULL;
                if( isset($deathInfo) AND $deathInfo->Type_of_Death) {
                    $ToD = $deathInfo->Type_of_Death;
                }
              ?>
              <div class="form-group">
                <label for="inputTypeofDeath">Type of Death</label>
                {!!Form::select('inputTypeofDeath',
                array(NULL =>'--Select--',
                      'M'=>'Maternal',
                      'N'=>'Neonatal',
                      'O'=>'Others'),
                $ToD, ['class' => 'form-control required', 'id' => 'inputTypeofDeath', 'required'=>'required']) !!}
              </div>
            <?php
                $mSD = NULL;
                if( isset($deathInfo) AND $deathInfo->mStageDeath) {
                    $mSD = $deathInfo->mStageDeath;
                }
              ?>
            <div class="form-group">
                <label for="inputMaternalDeath">Stage of Maternal Death occur</label>
                {!!Form::select('inputMaternalDeath',
                array(NULL =>'--Select--',
                      '01'=>'Prenatal Phase',
                      '02'=>'Labor and Delivery Phase',
                      '03'=>'Postpartum Phase',
                      '99'=>'Not Applicable'),
                $mSD, ['class' => 'form-control', 'id' => 'inputMaternalDeath']) !!}
              </div>
            <div class="form-group">
              <label for="inputCauseofDeathNotes">Notes</label>
              <textarea class="form-control" name="inputCauseofDeathNotes" id="inputCauseofDeathNotes">
               @if( isset($deathInfo) AND $deathInfo->Remarks) {{ $deathInfo->Remarks }} @endif
              </textarea>
            </div>
          </div>
          </fieldset>
            <div class="modal-footer">
                @if(!isset($deathInfo))
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                @else
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                @endif
            </div>
        {!! Form::close() !!}
        </div>


<script>
    $(document).on("click", ".deathModal", function () {
        var patient_id = $(this).data('id');
        $("#deathModal #patient_id").val( patient_id );
    });

    $('#deathModal').on('shown.bs.modal', function (e) {
        // do something...
        $(this).find('.form-control').val("");
    })

    $('#deliveryPlace_select').change(function(e) {
        var value = $.trim( this.value );

        if(value=='FB') {
          $("#deliveryPlaceHead").removeClass("hidden");
          $("#deliveryplace_FB").removeClass("hidden");
          $("#deliveryplace_FB").addClass("required");
          $("#deliveryplace_FB").attr("required", "required");
          $("#deliveryplace_NID").addClass("hidden");
          $('#deliveryplace_NID :selected').removeAttr("selected");
          $('#deliveryplace_NID').removeAttr("required");
          $('#deliveryplace_NID').removeClass("required");

        } else if(value=='NID') {
          $("#deliveryPlaceHead").removeClass("hidden");
          $("#deliveryplace_NID").removeClass("hidden");
          $("#deliveryplace_NID").addClass("required");
          $("#deliveryplace_NID").attr("required", "required");
          $("#deliveryplace_FB").addClass("hidden");
          $("#deliveryplace_FB :selected").removeAttr("selected");
          $("#deliveryplace_FB").removeAttr("required");
          $('#deliveryplace_FB').removeClass("required");

        } else {
          $("#deliveryPlaceHead").addClass("hidden");
          $("#deliveryplace_FB").addClass("hidden");
          $("#deliveryplace_NID").addClass("hidden");
          $("#deliveryplace_FB").removeAttr("required");
          $('#deliveryplace_FB').removeClass("required");
          $('#deliveryplace_NID').removeAttr("required");
          $('#deliveryplace_NID').removeClass("required");
        }
    });


    $('#deliveryplace_NID').change(function(e) {
        var oth = $.trim( this.value );
        if(oth=='oth') {
          $("#nidOthersSpecifiy").removeClass("hidden");
          $("#nidOthersSpecifiy input").addClass("required");
          $("#nidOthersSpecifiy input").attr("required","required");
        } else {
          $("#nidOthersSpecifiy").addClass("hidden");
          $("#nidOthersSpecifiy input").removeClass("required");
          $("#nidOthersSpecifiy input").removeAttr("required");
        }
    });

</script>
