 <!-- Modal form-->
    <div class="modal fade" id="deathModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Declare Patient Dead</h4>
          </div>
          <?php //dd($patient); ?>
            @if (isset($patient))
              {!! Form::model($patient, array('url' => 'patients/saveDeathInfo','class'=>'form-horizontal', 'method'=>'PATCH')) !!}
              <input type="hidden" name="patient_id" id="patient_id" value=""/>
            @else
            {!! Form::open(array('url' => 'patients/viewDeathInfo','class'=>'form-horizontal')) !!}
            @endif
            <div class="modal-body" id="modal-body">
              <div class="form-group">
                <label for="inputDeathCertificate">Death Certificate File <small>(if any)</small></label>
                <input type="file" id="inputDeathCertificate" name="inputDeathCertificate">
              </div>
              <div class="form-group">
                <label for="DeathCertificateNo">Death Certificate Number</label>
                <input type="text" class="form-control" name="DeathCertificateNo" id="DeathCertificateNo" placeholder="Death Certificate Number">
              </div>
              <div class="form-group">
                <label for="inputDateTimeDeath">Date and Time of Death</label>
                <input type="text" class="form-control" name="inputDateTimeDeath" id="datetimepicker" placeholder="Death Time and Day" value="{{ date("m/d/Y h:i A") }}">
              </div> 
              <div class="form-group">
                <label for="Immediate_Cause_of_Death">Immediate Cause of Death</label>
                <input type="text" class="form-control" name="Immediate_Cause_of_Death" id="Immediate_Cause_of_Death" placeholder="Disease, injury or complication that led directly to death">
              </div>
              <div class="form-group">
                <label for="Antecedent_Cause_of_Death">Antecedent Cause of Death</label>
                <input type="text" class="form-control" name="Antecedent_Cause_of_Death" id="Antecedent_Cause_of_Death" placeholder="Conditions giving rise to the immediate cause of death">
              </div>
              <div class="form-group">
                <label for="Underlying_Cause_of_Death">Underlying Cause of Death</label>
                <input type="text" class="form-control" name="Underlying_Cause_of_Death" id="Underlying_Cause_of_Death" placeholder="Disease or injury that initiated the train of events leading directly to death">
              </div>
              <div class="form-group">
                <label for="deathPlaceType">Place of Death</label>
                <div>
                  {!!Form::select('deathPlaceType',
                  array(NULL =>'--Select--',
                        'NID' => 'Non-Institutional Death',
                        'FB' => 'Facility-Based'), 
                  '', ['class' => 'form-control', 'id' => 'deliveryPlace_select']) !!} 
                </div>
                <div id="deliveryPlaceHead" class="hidden">
                  <div class="form-group">
                    <div> 
                        {!!Form::select('deathplace_FB',
                        array(  NULL =>'--Select--',
                                'bhs' => 'Barangay Health Station',
                                'rhu' => 'Rural Health Unit',
                                'hp'  => 'Hospital',
                                'LBC' => 'Lying-in / Birthing Clinics',
                                'pc'  => 'Private Clinic'),
                        '', ['class' => 'form-control hidden', 'id' => 'deliveryplace_FB']) !!}
             
                        {!!Form::select('deathplace_NID',
                        array(  NULL =>'--Select--',
                                'hme' => 'Home',
                                'hsp' => 'In Transit',
                                'oth' => 'Others'),
                        '', ['class' => 'form-control hidden', 'id' => 'deliveryplace_NID']) !!}           
                    </div>
                    <div id="nidOthersSpecifiy" class="hidden"> 
                        {!!Form::text('deathplace_NID_Others', '', ['class' => 'form-control', 'id' => 'deathplace_NID_Others', 'placeholder' => 'Specify place of death']) !!} 
                    </div> 
                  </div>
                </div>
              </div> 
              <div class="form-group">
                <label for="inputTypeofDeath">Type of Death</label>
                {!!Form::select('inputTypeofDeath',
                array(NULL =>'--Select--',
                      'M'=>'Maternal',
                      'N'=>'Neonatal',
                      'O'=>'Others'), 
                '', ['class' => 'form-control', 'id' => 'inputTypeofDeath']) !!}
              </div>
            <div class="form-group">
                <label for="inputMaternalDeath">Stage of Maternal Death occur</label>
                {!!Form::select('inputMaternalDeath',
                array(NULL =>'--Select--',
                      '01'=>'Prenatal Phase', 
                      '02'=>'Labor and Delivery Phase', 
                      '03'=>'Postpartum Phase', 
                      '99'=>'Not Applicable'), 
                '', ['class' => 'form-control', 'id' => 'inputMaternalDeath']) !!}
              </div>
            <div class="form-group">
              <label for="inputCauseofDeathNotes">Notes</label>
              <textarea class="form-control" name="inputCauseofDeathNotes" id="inputCauseofDeathNotes"></textarea>
            </div>
          </div>
          <div class="modal-footer" id="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- end of modal -->

<script>
  $(document).on("click", ".deathModal", function () {
     var patient_id = $(this).data('id');
     $("#deathModal #patient_id").val( patient_id );
    });

    $('#deliveryPlace_select').change(function(e) {
        var value = $.trim( this.value );
        
        if(value=='FB') {
          $("#deliveryPlaceHead").removeClass("hidden");
          $("#deliveryplace_FB").removeClass("hidden");
          $("#deliveryplace_NID").addClass("hidden");
          $('#deliveryplace_NID :selected').removeAttr("selected"); 

        } else if(value=='NID') {
          $("#deliveryPlaceHead").removeClass("hidden");
          $("#deliveryplace_NID").removeClass("hidden");
          $("#deliveryplace_FB").addClass("hidden");
          $("#deliveryplace_FB :selected").removeAttr("selected");

        } else {
          $("#deliveryPlaceHead").addClass("hidden");
          $("#deliveryplace_FB").addClass("hidden");
          $("#deliveryplace_NID").addClass("hidden");
        } 
    }); 

    
    $('#deliveryplace_NID').change(function(e) {
        var oth = $.trim( this.value );
        if(oth=='oth') {
          $("#nidOthersSpecifiy").removeClass("hidden");
        } else {
          $("#nidOthersSpecifiy").addClass("hidden");
        }
    });

    

</script>