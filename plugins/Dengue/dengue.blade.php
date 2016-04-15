
<?php
    $hservice_id = $data['healthcareservice_id'];
    $dservice_id = $data['dengue_id'];
?>

<?php
if($data['is_submitted'] == false) { $read = ''; }
else { $read = 'disabled'; }
?>

<div class="tab-content">

<div id="dengue" class="tab-pane step active">
  <!-- if there's family planning background - make this uneditable proceed to Family Planning -->
{!! Form::model($data, array('url' => 'plugin/call/Dengue/Dengue/save/'.$hservice_id,'class'=>'form-horizontal')) !!}
{!! Form::hidden('dservice_id',$dservice_id) !!}
{!! Form::hidden('hservice_id',$hservice_id) !!}
<label class="col-md-12 control-label"><small>*To accurately monitor Dengue Fever, please make sure to fill out the "Vitals & Physical" tab every 6 hours</small></label>
        <legend>Fever Overview</legend>
        <fieldset class="col-md-6">
            
            <label class="col-md-4 control-label">Fever Lasting 2-7 Days</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['fever_lasting'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Lasting" id="" value="Y" <?php if($data['fever_lasting'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['fever_lasting'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Lasting" id="" value="N" <?php if($data['fever_lasting'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['fever_lasting'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Lasting" id="" value="U" <?php if($data['fever_lasting'] == 'U') {echo "checked=\'checked\' ";} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Fever Now (>38&deg;C) 2-7 Days</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['fever_now'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Now" id="" value="Y" <?php if($data['fever_now'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['fever_now'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Now" id="" value="N" <?php if($data['fever_now'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['fever_now'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Fever_Now" id="" value="U" <?php if($data['fever_now'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Platelets ≤100,000/mm<sup>3</sup></label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['platelets_critical'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Platelets_Critical" id="" value="Y" <?php if($data['platelets_critical'] == 'U') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['platelets_critical'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Platelets_Critical" id="" value="N" <?php if($data['platelets_critical'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['platelets_critical'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Platelets_Critical" id="" value="U" <?php if($data['platelets_critical'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Platelet Count</sup></label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Platelet_Count" value="<?php echo $data['platelet_count'] ?>" placeholder="Platelet Count" {{$read}}>
          </div>
        </fieldset>
        


        <!-----FEVER OVERVIEW ------>
        <legend>Symptoms Overview</legend>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Rapid, Weak Pulse</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['rapid_weak_pulse'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rapid_Weak_Pulse" id="" value="Y"  <?php if($data['rapid_weak_pulse'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['rapid_weak_pulse'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rapid_Weak_Pulse" id="" value="N" <?php if($data['rapid_weak_pulse'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['rapid_weak_pulse'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rapid_Weak_Pulse" id="" value="U" <?php if($data['rapid_weak_pulse'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Pallor or Cool Skin</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['pallor_cool_skin'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pallor_Cool_Skin" id="" value="Y" <?php if($data['pallor_cool_skin'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['pallor_cool_skin'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pallor_Cool_Skin" id="" value="N" <?php if($data['pallor_cool_skin'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['pallor_cool_skin'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pallor_Cool_Skin" id="" value="U" <?php if($data['pallor_cool_skin'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Chills</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['chills'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Chills" id="" value="Y" <?php if($data['chills'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['chills'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Chills" id="" value="N" <?php if($data['chills'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['chills'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Chills" id="" value="U" <?php if($data['chills'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Rash</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['rash'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rash" id="" value="Y" <?php if($data['rash'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['rash'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rash" id="" value="N" <?php if($data['rash'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['rash'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Rash" id="" value="U" <?php if($data['rash'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Headache</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['headache'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Headache" id="" value="Y" <?php if($data['headache'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['headache'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Headache" id="" value="N" <?php if($data['headache'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['headache'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Headache" id="" value="U" <?php if($data['headache'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Eye Pain</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['eye_pain'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Eye_Pain" id="" value="Y" <?php if($data['eye_pain'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['eye_pain'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Eye_Pain" id="" value="N" <?php if($data['eye_pain'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['eye_pain'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Eye_Pain" id="" value="U" <?php if($data['eye_pain'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Body Pain</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['body_pain'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Body_Pain" id="" value="Y" <?php if($data['body_pain'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['body_pain'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Body_Pain" id="" value="N" <?php if($data['body_pain'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['body_pain'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Body_Pain" id="" value="U" <?php if($data['body_pain'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Joint Pain </label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['joint_pain'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Joint_Pain" id="" value="Y" <?php if($data['joint_pain'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['joint_pain'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Joint_Pain" id="" value="N" <?php if($data['joint_pain'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['joint_pain'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Joint_Pain" id="" value="U" <?php if($data['joint_pain'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Anorexia</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['anorexia'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Anorexia" id="" value="Y" <?php if($data['anorexia'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['anorexia'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Anorexia" id="" value="N" <?php if($data['anorexia'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['anorexia'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Anorexia" id="" value="U" <?php if($data['anorexia'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Tourniquet Test</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['tourniquet_test'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Tourniquet_Test" id="" value="Y" <?php if($data['tourniquet_test'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Positive
                  </label>
                  <label class="btn btn-default <?php if($data['tourniquet_test'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Tourniquet_Test" id="" value="N" <?php if($data['tourniquet_test'] == 'N') {echo 'checked=\'checked\' ';} ?>> Negative
                  </label>
                  <label class="btn btn-default <?php if($data['tourniquet_test'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Tourniquet_Test" id="" value="U" <?php if($data['tourniquet_test'] == 'U') {echo 'checked=\'checked\' ';} ?>> Not Done Yet
                  </label>
                </div>
            </div>
        </fieldset>

        <!-----HEMORRHAGIC MANIFESTATION ------>
        <legend>Hemorrhagic Manifestation</legend>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Petechiae</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['petechiae'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Petechiae" id="" value="Y" <?php if($data['petechiae'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['petechiae'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Petechiae" id="" value="N" <?php if($data['petechiae'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['petechiae'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Petechiae" id="" value="U" <?php if($data['petechiae'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Purpura/Ecchymosis</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['purpura_ecchymosis'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Purpura_Ecchymosis" id="" value="Y" <?php if($data['purpura_ecchymosis'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['purpura_ecchymosis'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Purpura_Ecchymosis" id="" value="N" <?php if($data['purpura_ecchymosis'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['purpura_ecchymosis'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Purpura_Ecchymosis" id="" value="U" <?php if($data['purpura_ecchymosis'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Vomit With Blood</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['vomit_with_blood'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vomit_With_Blood" id="" value="Y" <?php if($data['vomit_with_blood'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['vomit_with_blood'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vomit_With_Blood" id="" value="N" <?php if($data['vomit_with_blood'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['vomit_with_blood'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vomit_With_Blood" id="" value="U" <?php if($data['vomit_with_blood'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Blood in Stool</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['blood_in_stool'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Blood_In_Stool" id="" value="Y" <?php if($data['blood_in_stool'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['blood_in_stool'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Blood_In_Stool" id="" value="N" <?php if($data['blood_in_stool'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['blood_in_stool'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Blood_In_Stool" id="" value="U" <?php if($data['blood_in_stool'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Nasal Bleeding</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['nasal_bleeding'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Bleeding" id="" value="Y" <?php if($data['nasal_bleeding'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['nasal_bleeding'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Bleeding" id="" value="N" <?php if($data['nasal_bleeding'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['nasal_bleeding'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Bleeding" id="" value="U" <?php if($data['nasal_bleeding'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Vaginal Bleeding</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['vaginal_bleeding'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vaginal_Bleeding" id="" value="Y" <?php if($data['vaginal_bleeding'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['vaginal_bleeding'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vaginal_Bleeding" id="" value="N" <?php if($data['vaginal_bleeding'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['vaginal_bleeding'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Vaginal_Bleeding" id="" value="U" <?php if($data['vaginal_bleeding'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Positive Urinalysis <small> (over 5 RBC/hpf or positive for blood)</small></label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['positive_urinalysis'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Positive_Urinalysis" id="" value="Y" <?php if($data['positive_urinalysis'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['positive_urinalysis'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Positive_Urinalysis" id="" value="N" <?php if($data['positive_urinalysis'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['positive_urinalysis'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Positive_Urinalysis" id="" value="U" <?php if($data['positive_urinalysis'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>

        <!-----EVIDENCE OF CAPILLARY LEAK------>
        <legend>Evidence of Capillary Leak</legend>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest Hematocrit (%)</label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Lowest_Hematocrit" value="<?php echo $data['lowest_hematocrit'] ?>" placeholder="Lowest Hematocrit (%)" {{$read}}>
            <!--{!! Form::number('Lowest_Hematocrit', $data['lowest_hematocrit'], ['class' => 'form-control', 'placeholder'=>'Lowest Hematocrit (%)']) !!}-->
          </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Highest Hematocrit (%)</label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Highest_Hematocrit" value="<?php echo $data['highest_hematocrit'] ?>" placeholder="Highest Hematocrit (%)" {{$read}}>
          </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest Serum Albumin</label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Lowest_Serum_Albumin" value="<?php echo $data['lowest_serum_albumin'] ?>" placeholder="Lowest Serum Albumin" {{$read}}>
          </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest Serum Protein</label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Lowest_Serum_Protein" value="<?php echo $data['lowest_serum_protein'] ?>" placeholder="Lowest Serum Protein" {{$read}}>
          </div>
        </fieldset>
        <!--<fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest Blood Pressure <small>(SBP/DBP)</small></label>
            <div class="col-md-4">
              <input type="number" class="form-control" name="Lowest_BP_SBP" value="<?//php echo $data['lowest_bp_sbp'] ?>" placeholder="SBP" {{$read}}>
            </div>
            <div class="col-md-4">
              <input type="number" class="form-control" name="Lowest_BP_DBP" value="<?php //echo $data['lowest_bp_dbp'] ?>" placeholder="DBP" {{$read}}>
            </div>
        </fieldset>-->
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest Pulse Pressure <small>(Systolic - Diastolic)</small></label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Lowest_Pulse_Pressure" value="<?php echo $data['lowest_pulse_pressure'] ?>" placeholder="Lowest Pulse Pressure" {{$read}}>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lowest White Blood Cell Count <small>(Systolic - Diastolic)</small></label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="Lowest_WBC_Count" value="<?php echo $data['lowest_wbc_count'] ?>" placeholder="Lowest White Blood Cell Count" {{$read}}>
            </div>
        </fieldset>

        <!-----WARNING SIGNS------>
        <legend>Warning Signs</legend>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Persistent Vomiting</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['persistent_vomiting'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Persistent_Vomiting" id="" value="Y" <?php if($data['persistent_vomiting'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['persistent_vomiting'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Persistent_Vomiting" id="" value="N" <?php if($data['persistent_vomiting'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['persistent_vomiting'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Persistent_Vomiting" id="" value="U" <?php if($data['persistent_vomiting'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Abdominal Pain/Tenderness</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['abdominal_pain_tenderness'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Abdominal_Pain_Tenderness" id="" value="Y" <?php if($data['abdominal_pain_tenderness'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['abdominal_pain_tenderness'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Abdominal_Pain_Tenderness" id="" value="N" <?php if($data['abdominal_pain_tenderness'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['abdominal_pain_tenderness'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Abdominal_Pain_Tenderness" id="" value="U" <?php if($data['abdominal_pain_tenderness'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Mucosal Bleeding</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['mucosal_bleeding'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Mucosal_Bleeding" id="" value="Y" <?php if($data['mucosal_bleeding'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['mucosal_bleeding'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Mucosal_Bleeding" id="" value="N" <?php if($data['mucosal_bleeding'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['mucosal_bleeding'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Mucosal_Bleeding" id="" value="U" <?php if($data['mucosal_bleeding'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Lethargy, Restlessness</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['lethargy_restlessness'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Lethargy_Restlessness" id="" value="Y" <?php if($data['lethargy_restlessness'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['lethargy_restlessness'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Lethargy_Restlessness" id="" value="N" <?php if($data['lethargy_restlessness'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['lethargy_restlessness'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Lethargy_Restlessness" id="" value="U" <?php if($data['lethargy_restlessness'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Liver Enlargement <small>(>2cm)</small></label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['liver_enlargement'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Liver_Enlargement" id="" value="Y" <?php if($data['liver_enlargement'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['liver_enlargement'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Liver_Enlargement" id="" value="N" <?php if($data['liver_enlargement'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['liver_enlargement'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Liver_Enlargement" id="" value="U" <?php if($data['liver_enlargement'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Pleural or Abdominal Effusion</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['pleural_or_abdominal_effusion'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pleural_Or_Abdominal_Effusion" id="" value="Y" <?php if($data['pleural_or_abdominal_effusion'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['pleural_or_abdominal_effusion'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pleural_Or_Abdominal_Effusion" id="" value="N" <?php if($data['pleural_or_abdominal_effusion'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['pleural_or_abdominal_effusion'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Pleural_Or_Abdominal_Effusion" id="" value="U" <?php if($data['pleural_or_abdominal_effusion'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>

        <!-----ADDITIONAL SYMPTOMS------>
        <legend>Additional Symptoms</legend>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Diarrhea</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['diarrhea'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Diarrhea" id="" value="Y" <?php if($data['diarrhea'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['diarrhea'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Diarrhea" id="" value="N" <?php if($data['diarrhea'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['diarrhea'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Diarrhea" id="" value="U" <?php if($data['diarrhea'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Cough</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['cough'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Cough" id="" value="Y" <?php if($data['cough'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['cough'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Cough" id="" value="N" <?php if($data['cough'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['cough'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Cough" id="" value="U" <?php if($data['cough'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Conjunctivitis</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['conjunctivitis'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Conjunctivitis" id="" value="Y" <?php if($data['conjunctivitis'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['conjunctivitis'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Conjunctivitis" id="" value="N" <?php if($data['conjunctivitis'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['conjunctivitis'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Conjunctivitis" id="" value="U" <?php if($data['conjunctivitis'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Nasal Congestion</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['nasal_congestion'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Congestion" id="" value="Y" <?php if($data['nasal_congestion'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['nasal_congestion'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Congestion" id="" value="N" <?php if($data['nasal_congestion'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['nasal_congestion'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nasal_Congestion" id="" value="U" <?php if($data['nasal_congestion'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Sore Throat</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['sore_throat'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Sore_Throat" id="" value="Y" <?php if($data['sore_throat'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['sore_throat'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Sore_Throat" id="" value="N" <?php if($data['sore_throat'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['sore_throat'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Sore_Throat" id="" value="U" <?php if($data['sore_throat'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Jaundice</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['jaundice'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Jaundice" id="" value="Y" <?php if($data['jaundice'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['jaundice'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Jaundice" id="" value="N" <?php if($data['jaundice'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['jaundice'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Jaundice" id="" value="U" <?php if($data['jaundice'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Convulsion or Coma</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['convulsion_or_coma'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Convulsion_Or_Coma" id="" value="Y" <?php if($data['convulsion_or_coma'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['convulsion_or_coma'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Convulsion_Or_Coma" id="" value="N" <?php if($data['convulsion_or_coma'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['convulsion_or_coma'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Convulsion_Or_Coma" id="" value="U" <?php if($data['convulsion_or_coma'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Nausea and Vomiting</label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['nausea_and_vomiting'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nausea_And_Vomiting" id="" value="Y" <?php if($data['nausea_and_vomiting'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['nausea_and_vomiting'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nausea_And_Vomiting" id="" value="N" <?php if($data['nausea_and_vomiting'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['nausea_and_vomiting'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Nausea_And_Vomiting" id="" value="U" <?php if($data['nausea_and_vomiting'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-md-6">
            <label class="col-md-4 control-label">Arthritis <small>(Swollen Joints)</small></label>
            <div class="col-sm-8">
                <div class="btn-group toggler" data-toggle="buttons">
                  <label class="btn btn-default <?php if($data['arthritis'] == 'Y') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Arthritis" id="" value="Y" <?php if($data['arthritis'] == 'Y') {echo 'checked=\'checked\' ';} ?>> Yes
                  </label>
                  <label class="btn btn-default <?php if($data['arthritis'] == 'N') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Arthritis" id="" value="N" <?php if($data['arthritis'] == 'N') {echo 'checked=\'checked\' ';} ?>> No
                  </label>
                  <label class="btn btn-default <?php if($data['arthritis'] == 'U') {echo 'active';} ?>" {{$read}}>
                    <i class="fa fa-check"></i> <input type="radio" name="Arthritis" id="" value="U" <?php if($data['arthritis'] == 'U') {echo 'checked=\'checked\' ';} ?>> Unknown
                  </label>
                </div>
            </div>
        </fieldset>



  <?php if($data['is_submitted'] == false) { ?>
    <div class="form-group pull-right">
        <!--<button type="button" class="btn btn-primary" onclick="#'">Close</button>-->
          <button type="submit" value="submit" class="btn btn-success">Submit</button>
    </div>
  <?php } ?>
  
    {!! Form::close() !!}
    <br clear="all" />
</div>
</div>
