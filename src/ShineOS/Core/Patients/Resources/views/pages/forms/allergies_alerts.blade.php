<div class="tab-pane step" id="health">
    <fieldset>
        <legend>Basic Health Information</legend>
        <div class="form-group ">
            <?php
                $blood = "";
                $btypeam = FALSE;
                $btypeap = FALSE;
                $btypeabm = FALSE;
                $btypeabp = FALSE;
                $btypebm = FALSE;
                $btypebp = FALSE;
                $btypeom = FALSE;
                $btypeop = FALSE;
                $btypeu = FALSE;

                if(isset($patient) AND $patient->blood_type == 'A-') $btypeam = TRUE;
                if(isset($patient) AND $patient->blood_type == 'A+') $btypeap = TRUE;
                if(isset($patient) AND $patient->blood_type == 'AB-') $btypeabm = TRUE;
                if(isset($patient) AND $patient->blood_type == 'AB+') $btypeabp = TRUE;
                if(isset($patient) AND $patient->blood_type == 'B-') $btypebm = TRUE;
                if(isset($patient) AND $patient->blood_type == 'B+') $btypebp = TRUE;
                if(isset($patient) AND $patient->blood_type == 'O-') $btypeom = TRUE;
                if(isset($patient) AND $patient->blood_type == 'O+') $btypeop = TRUE;
                if(isset($patient) AND $patient->blood_type == 'U') $btypeu = TRUE;
                if(isset($patient) AND $patient->blood_type) $blood = $patient->blood_type;
            ?>
            <label class="control-label col-sm-2">Blood Type *</label>
            <div class="col-sm-10">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='A-') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'A-', $btypeam, array('onchange'=>"$('#blood_field').val(this.value);")) !!} A-
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='A+') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'A+', $btypeap, array('onchange'=>"$('#blood_field').val(this.value);")) !!} A+
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='AB-') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'AB-', $btypeabm, array('onchange'=>"$('#blood_field').val(this.value);")) !!} AB-
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='AB+') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'AB+', $btypeabp, array('onchange'=>"$('#blood_field').val(this.value);")) !!} AB+
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='B-') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'B-', $btypebm, array('onchange'=>"$('#blood_field').val(this.value);")) !!} B-
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='B+') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'B+', $btypebp, array('onchange'=>"$('#blood_field').val(this.value);")) !!} B+
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='O-') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'O-', $btypeom, array('onchange'=>"$('#blood_field').val(this.value);")) !!} O-
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='O+') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'O+', $btypeop, array('onchange'=>"$('#blood_field').val(this.value);")) !!} O+
                  </label>
                  <label class="btn btn-default required @if(isset($patient) AND $patient->blood_type=='U') active @endif">
                      <i class="fa fa-check"></i>
                    {!! Form::radio('inputPatientBloodType', 'U', $btypeu, array('onchange'=>"$('#blood_field').val(this.value);")) !!} Unknown
                  </label>
                </div>
                <input type="hidden" name="inputPatientBloodType" class="required marginb-2" id="blood_field" value="{{ $blood }}" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Alerts, Allergies and Disabilities</legend>
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
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="alert[]" id="chk_aller" value="ALLER" {{ $aller }}>
                  Has Allergy
                </label>
              </div>
              <!-- <div id="allergies"> -->
              <?php
              $allergy_show = "hide";
              if($aller != NULL) {
                $allergy_show = "";
              } ?>
              <div id="allergies" class="{{ $allergy_show }}">
              <div name="parentDiv" class="row parentDiv">
               <?php if(isset($patient->patientAllergies[0])) {
                    $c = 0;
                    foreach($patient->patientAllergies as $allergy) {
                        $c++;
                    ?>
                    <div class="col-md-12 clone">
                        <label class="col-sm-1 control-label">Allergy</label>
                        <div class="col-sm-3">
                            <input value="{{ $allergy->allergy_id }}" type="text" class="form-control allergyname" name="allergy[inputAllergyName][]"  placeholder="Allergy">
                        </div>
                        <label class="col-sm-1 control-label">Reaction</label>
                        <div class="col-sm-3">
                            <select class="form-control allergyreaction" name="allergy[inputAllergyReaction][]">
                                <option disabled="" selected="">Choose reaction</option>

                                @foreach ($allergyReactions as $reaction)
                                  <option value="{{ $reaction->allergyreaction_id }}" @if($allergy->allergy_reaction_id == $reaction->allergyreaction_id) selected='selected' @endif>{{ $reaction->allergyreaction_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <label class="col-sm-1 control-label">Severity</label>
                        <div class="col-sm-2">
                            <select class="form-control allergyseverity" name="allergy[inputAllergySeverity][]">
                                <option disabled selected>Choose severity</option>
                                <option value="Mild" class="text-yellow"  @if($allergy->allergy_severity == "Mild") selected='selected' @endif>Mild</option>
                                <option value="Moderate" class="text-red"  @if($allergy->allergy_severity == "Moderate") selected='selected' @endif>Moderate</option>
                                <option value="Severe" class="red"  @if($allergy->allergy_severity == "Severe") selected='selected' @endif>Severe</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <?php $h = 'hidden'; if( $c > 1 ) $h = ''; ?>
                            <button class="removeAllergyLine btn btn-danger btn-sm {{ $h }}"><i class="fa fa-times"></i></button>

                        </div>

                    </div><!-- /.box-body -->
               <?php } } else { ?>
                    <div class="col-md-12 clone">
                        <label class="col-sm-1 control-label">Allergy</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control allergyname" name="allergy[inputAllergyName][]"  placeholder="Allergy">
                        </div>
                        <label class="col-sm-1 control-label">Reaction</label>
                        <div class="col-sm-3">
                            <select class="form-control allergyreaction" name="allergy[inputAllergyReaction][]">
                                <option disabled="" selected="">Choose reaction</option>

                                @foreach ($allergyReactions as $reaction)
                                  <option value="{{ $reaction->allergyreaction_id }}">{{ $reaction->allergyreaction_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-1 control-label">Severity</label>
                        <div class="col-sm-2">
                            <select class="form-control allergyseverity" name="allergy[inputAllergySeverity][]">
                                <option disabled selected>Choose severity</option>
                                <option value="Mild" class="text-warning">Mild</option>
                                <option value-"Moderate" class="text-red">Moderate</option>
                                <option value="Severe" class="text-maroon">Severe</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="removeAllergyLine hidden btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-body -->
                <?php } ?>
              </div><!-- box-footer -->
              <br />
              <button type="button" class="btn btn-default btn-sm addAllergy-button pull-right"><i class="fa fa-plus"></i> Add allergy </button>
              <br clear='all' />
              <hr />
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="alert[]" id="chk_disab" value="DISAB" {{ $disab }}>
                  Has Disability
                </label>
              </div>
              <?php
              $disab_show = "hide";
              if($disab != NULL) {
                $disab_show = "";
              } ?>
              <div id="disabilities" class="{{ $disab_show }}">
                @if (isset($disabilities))
                  <?php
                    if(isset($patient)):
                        $disabArray = array();
                        foreach ($patient->patientDisabilities as $disabItem) {
                            $disabArray[$disabItem->disability_id] = $disabItem->id;
                        }
                    endif
                  ?>
                  @foreach ($disabilities as $val)
                    <div class="checkbox col-md-4">
                      @if ($disab != NULL)
                            @if( isset($disabArray[$val->disability_id]) )
                                {!! Form::checkbox('disability[]', $val->disability_id, true) !!}
                            @else
                                {!! Form::checkbox('disability[]', $val->disability_id) !!}
                            @endif
                      @else
                        {!! Form::checkbox('disability[]', $val->disability_id) !!}
                      @endif

                      {{ $val->disability_name }}
                    </div>
                  @endforeach
                @endif
                <br clear='all' />
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="alert[]" value="DRUGS" {{ $drugs }}>
                  Is Drug Dependent
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="alert[]" value="HANDI" {{ $handi }}>
                  Is Handicap
                </label>
              </div>
              <div class="checkbox-inline">
                <label>
                  <input type="checkbox" name="alert[]" value="IMPAI" {{ $impai }}>
                  Has Impairment
                </label>
              </div>
              <?php
                $alert_other_show = "hide";
                if($other) {
                    $alert_other_show = "";
                }
              ?>
              <div class="checkbox form-inline">
                  <label class="checkbox-inline pull-left">
                    <input type="checkbox" name="alert[]" value="OTHER" id="chk_other" {{ $other }}>
                    Specify other alerts
                  </label>
                  <div class="other alert-other {{ $alert_other_show }}">
                    <input type="text" class="form-control col-md-3 alert_other_field" name="inputAlertOthers"  placeholder="Other Alerts" value="{{ $aother }}">
                  </div>
              </div>

            </div>
            </div>
    </fieldset>

</div><!-- /.tab-pane -->
