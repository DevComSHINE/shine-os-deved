
<div class="modal-header bg-blue-gradient">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myInfoModalLabel"> {{ $qvTitle }} </h4>
</div>
<div class="modal-body icheck">
    <h3 class="no-margin-top">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          @if( $patient->patientAlert->count() > 0 )
          <div class="panel panel-default">
            <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="headingOne">
              <h4 class="panel-title">
                <a >
                  Alerts, Allergies and Disabilities
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <!-- start allergy panel -->
                <fieldset>
                    <?php
                        $drugs = $drugsid = NULL;
                        $aller = $allerid = NULL;
                        $disab = $disabid = NULL;
                        $handi = $handiid = NULL;
                        $impai = $impaiid = NULL;
                        $notap = $notapid = NULL;
                        $other = $otherid = $aother = NULL;
                        if(isset($patient)){
                            foreach($patient->patientAlert as $alert){
                                if($alert->alert_type == "DRUGS") { $drugs = "checked='checked'"; $drugsid = $alert->id; }
                                if($alert->alert_type == "ALLER") { $aller = "checked='checked'"; $allerid = $alert->id; }
                                if($alert->alert_type == "DISAB") { $disab = "checked='checked'"; $disabid = $alert->id; }
                                if($alert->alert_type == "HANDI") { $handi = "checked='checked'"; $handiid = $alert->id; }
                                if($alert->alert_type == "IMPAI") { $impai = "checked='checked'"; $impaiid = $alert->id; }
                                if($alert->alert_type == "NOTAP") { $notap = "checked='checked'"; $notapid = $alert->id; }
                                if($alert->alert_type == "OTHER") { $other = "checked='checked'"; $otherid = $alert->id; $aother = $alert->alert_type_other; }
                            }
                        }
                    ?>
                        <div class="col-sm-12 icheck">
                              <!-- <div id="allergies"> -->
                              <?php
                              $allergy_show = "hide";
                              if($aller != NULL) {
                                $allergy_show = "";
                              ?>
                              <div class="form-group">
                              <div class="checkbox">
                                <h4>Allergies</h4>
                              </div>
                              <div id="allergies" class="{{ $allergy_show }}">
                                  <div name="parentDiv" class="row parentDiv">
                                   <?php
                                        $c = 0;
                                        foreach($patient->patientAllergies as $allergy) {
                                            $c++;
                                        ?>
                                        <div class="col-md-12 clone">
                                            <label class="col-sm-1 control-label">Allergy</label>
                                            <div class="col-sm-3">
                                                {{ $allergy->allergy_id }}
                                            </div>
                                            <label class="col-sm-1 control-label">Reaction</label>
                                            <div class="col-sm-3">
                                                    @foreach ($allergyReactions as $reaction)
                                                      @if($allergy->allergy_reaction_id == $reaction->allergyreaction_id)
                                                        {{ $reaction->allergyreaction_name }}
                                                      @endif
                                                    @endforeach
                                            </div>
                                            <label class="col-sm-1 control-label">Severity</label>
                                            <div class="col-sm-2">
                                                @if($allergy->allergy_severity == "Mild") Mild @endif
                                                @if($allergy->allergy_severity == "Moderate") Moderate @endif
                                                @if($allergy->allergy_severity == "Severe") Severe @endif
                                            </div>

                                        </div><!-- /.box-body -->
                                   <?php } ?>
                                  </div><!-- box-footer -->
                              </div>
                            </div>
                              <?php } ?>

                              <?php
                              $disab_show = "hide";
                              if($disab != NULL) {
                                $disab_show = "";
                              ?>
                                <div class="form-group">
                                  <div class="checkbox">
                                    <h4>
                                      Disabilities
                                    </h4>
                                  </div>
                                  <div id="disabilities" class="{{ $disab_show }}">
                                    @if (isset($disabilities))
                                      <?php
                                        if(isset($patient)):
                                            $disabArray = array();
                                            foreach ($patient->patientDisabilities as $disabItem) {
                                                $disabArray[$disabItem->disability_id] = $disabItem->id;
                                            }
                                        endif;
                                      ?>
                                      @foreach ($disabilities as $val)
                                          @if ($disab != NULL)
                                                @if( isset($disabArray[$val->disability_id]) )
                                                <div class="checkbox col-md-4">
                                                    {!! Form::checkbox('disability[]', $val->disability_id, true) !!} {{ $val->disability_name }}
                                                </div>
                                                @endif
                                          @endif
                                      @endforeach
                                    @endif
                                    <br clear='all' />

                                  @if($drugs)
                                  <div class="checkbox-inline">
                                    <label>
                                      <input type="checkbox" name="alert[]" value="DRUGS" {{ $drugs }}>
                                      Is Drug Dependent
                                    </label>
                                  </div>
                                  @endif
                                  @if($handi)
                                  <div class="checkbox-inline">
                                    <label>
                                      <input type="checkbox" name="alert[]" value="HANDI" {{ $handi }}>
                                      Is Handicap
                                    </label>
                                  </div>
                                  @endif
                                  @if($impai)
                                  <div class="checkbox-inline">
                                    <label>
                                      <input type="checkbox" name="alert[]" value="IMPAI" {{ $impai }}>
                                      Has Impairment
                                    </label>
                                  </div>
                                  @endif
                                  </div>
                                <?php } ?>

                              <?php
                                $alert_other_show = "hide";
                                if($other) {
                                    $alert_other_show = ""; ?>
                                      <div class="checkbox form-inline">
                                          <h4 class="checkbox-inline pull-left">
                                            Other Alerts
                                          </h4>
                                          <div class="other alert-other {{ $alert_other_show }}">
                                            <input type="text" class="form-control col-md-3 alert_other_field" name="inputAlertOthers"  placeholder="Other Alerts" value="{{ $aother }}">
                                          </div>
                                      </div>
                              <?php } ?>
                        </div>
                </fieldset>
              </div>
            </div>
          </div>
          @endif

          @if( $patient->patientMedicalHistory->count() > 0 )
          <div class="panel panel-default">
            <div class="panel-heading" role="button" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h4 class="panel-title">
                <a class="collapsed">Medical History</a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                  <?php $pdat = $patient->patientMedicalHistory; ?>
                  <?php $thisnarrative = ""; ?>
                    @if($pdat)
                        @foreach($pdat as $c=>$a)
                            @if($a->disease_id == 'narrative')
                                <h4>Narrative</h4>
                                {{ $a->disease_status }}
                            @endif
                        @endforeach
                    @endif
                  <hr />
                  @foreach( $formdata as $name=>$data )
                    <?php $oktitle = 0; $go = 'N'; ?>
                    @foreach( $data as $med_history )
                        <?php foreach($pdat as $c=>$a) {
                            if($a->disease_id == $med_history->disease_id) {
                                $go = 'Y';
                            }
                        } ?>
                        <?php
                            if($go == 'Y') {
                                if($oktitle == 0) { echo "<strong>".$med_history->disease_category."</strong><br />"; }
                                $oktitle = 1;
                            ?>
                            <?php
                                $currentRadios = explode('|', $med_history->disease_radio_values);
                                foreach ( $currentRadios as $currRadio ) {
                                    if($pdat) {
                                        foreach($pdat as $c=>$a) {
                                            if($a->disease_id == $med_history->disease_id AND $a->disease_status == $currRadio AND $a->disease_status != NULL)
                                            {
                                                echo $med_history->disease_name."; ";
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    @endforeach
                    @if($go == 'Y') <hr /> @endif
                  @endforeach
              </div>
            </div>
          </div>
          @endif

          @if( $patient->patientMedicalHistory->count() == 0 AND $patient->patientAlert->count() == 0 )
          <div class="container">
              <h4 class="text-primary">No recorded medical history.</h4>
              <p>If you need to add medical history to this patient, click <a href="{{ url('patients/view/'.$patient->patient_id.'#history') }}" class="bg-green text-black kbd">Medical History | <i class="fa fa-sign-in"></i></a> to go there.</p>
          </div>
          @endif

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

