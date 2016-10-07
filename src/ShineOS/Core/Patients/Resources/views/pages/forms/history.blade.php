<?php
    $method = 'save';
    $pdat = NULL;
    if(isset($patient)) {
        if (!empty($patient->patientMedicalHistory)) {
            $method = 'update';
            $pdat = $patient->patientMedicalHistory;
        }
        $gender = $patient->gender;
        $age = getAge($patient->birthdate);
    } else {
        $gender = NULL;
        $age = NULL;
    }
    $number_type = array();
    /*$number_type = array("No_Pack_Smoke", "No_Bottle", 'Gravidity', 'Parity', 'Full_Term', 'Premature', 'Abortion', 'LiveBirth', 'BP_Diastolic', 'BP_Systolic', 'Menstrual_Period_Duration', 'No_Pads', 'Age_Menopausal', 'Menstrual_Cycle');*/
    $date_past = array('Last_Menstrual_Period', 'Date_of_Operation');

?>

<div class="tab-pane step icheck" id="history">
        <div class="col-md-6">
        <?php
        $hide = "";
        foreach($formdata as $name=>$data){
            $go = 'N';
            if(isset($data[0]) AND $data[0]->sex_limit==NULL AND $data[0]->max_age_limit==NULL AND $data[0]->min_age_limit <= $age){
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->sex_limit==NULL AND $data[0]->min_age_limit==NULL AND $data[0]->max_age_limit >= $age){
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->sex_limit==NULL AND $data[0]->min_age_limit <= $age AND $data[0]->max_age_limit >= $age) {
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->min_age_limit <= $age AND $data[0]->max_age_limit >= $age AND $data[0]->sex_limit == $gender) {
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->max_age_limit==NULL AND $data[0]->min_age_limit <= $age AND $data[0]->sex_limit == $gender) {
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->max_age_limit >= $age AND $data[0]->min_age_limit==NULL AND $data[0]->sex_limit == $gender) {
                $go = 'Y';
            }
            if(isset($data[0]) AND $data[0]->max_age_limit==NULL AND $data[0]->min_age_limit==NULL AND $data[0]->sex_limit == $gender) {
                $go = 'Y';
            }

            if(isset($data[0]) AND $data[0]->sex_limit==NULL AND $data[0]->max_age_limit==NULL AND $data[0]->min_age_limit==NULL) {
                $go = 'Y';
            } ?>

          @if($go == 'Y')
            <fieldset>
            <legend style="font-size:18px;">{{ $data[0]->disease_category}}</legend>
            <div class="">
                    <p>Complete the following fields for the patient's Medical History.</p>
                    <?php $currIndex = 0; $check = ""; $fvalue = ""; ?>
                        @foreach( $data as $med_history )

                            <?php if($med_history->before_after < 0) {
                            ?>
                            <dl class="col-md-{{ 6*($med_history->before_after+2) }}" style="height:55px;">
                            </dl>
                            <?php } ?>

                                <?php if ( $med_history->disease_input_type == 'radio' ) { ?>
                                <dl class="form-group col-md-{{ 6*($med_history->block_width) }}">
                                    <dt> {{ $med_history->disease_name }}</dt>
                                    <dd>
                                    <?php $currentRadios = explode('|', $med_history->disease_radio_values);
                                    foreach ( $currentRadios as $currRadio ) {

                                        if($pdat) {
                                            foreach($pdat as $c=>$a) {
                                                if($a->disease_id == $med_history->disease_id AND $a->disease_status == $currRadio)
                                                {
                                                    $check = "checked='checked'";
                                                }
                                            }
                                        } ?>
                                        <div class="radio inline">
                                            <label>
                                                <input type="radio" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" {{ $check }} value="{{ $currRadio }}" />
                                                {{ $currRadio }}
                                            </label>
                                        </div>
                                        <?php
                                        $check = "";
                                    } ?>
                                    </dd>
                                </dl>
                                <?php } elseif ( $med_history->disease_input_type == 'checkbox' ) { ?>
                                <dl class="form-group col-md-{{ 6*($med_history->block_width) }}"  style="padding-top:24px;">
                                    <dt class="col-md-2">
                                    <?php $currentRadios = explode('|', $med_history->disease_radio_values); ?>
                                    <?php foreach ( $currentRadios as $currRadio ) {
                                        if($pdat) {
                                            foreach($pdat as $c=>$a) {
                                                if($a->disease_id == $med_history->disease_id AND $a->disease_status == $currRadio)
                                                {
                                                    $check = "checked='checked'";
                                                }
                                            }
                                        } ?>
                                        <input type="checkbox" class='medhistchk' id='{{ str_slug($med_history->partner_field) }}' name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" {{ $check }} value="{{ $currRadio }}" />
                                        <?php $check = "";
                                    } ?>
                                    </dt>
                                    <dd class="col-md-10"> {{ $med_history->disease_name }}</dd>
                                </dl>
                                <?php } elseif( $med_history->disease_input_type == 'text' OR $med_history->disease_input_type == 'text_opt' ) { ?>
                                <dl class="form-group col-md-{{ 6*($med_history->block_width) }}">
                                    <dt> {{ $med_history->disease_name }}</dt>
                                    <dd>
                                    <?php if($pdat) {
                                        foreach($pdat as $c=>$a) {
                                            $fvalue = "";
                                            if($a->disease_id == $med_history->disease_id ) {
                                                $fvalue = $a->disease_status;
                                                break;
                                            }
                                        }
                                    } ?>

                                    @if(in_array($med_history->disease_code, $date_past))
                                        <!-- Datetime -->
                                        <input type="text" id="datepicker" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" value='{{ $fvalue }}' class="form-control" />
                                    @elseif(in_array($med_history->disease_code, $number_type))
                                        <!-- Number -->
                                        <input type="number" id="disease[{{ $med_history->disease_id }}]" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" value='{{ $fvalue }}' class="form-control" />
                                    @elseif($med_history->disease_code == 'Type_of_Delivery')
                                        <!-- Select -->
                                        <select id="disease[{{ $med_history->disease_id }}]" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" class="form-control">
                                            <option value="NULL">--Select--</option>
                                            <option value="N">Normal</option>
                                            <option value="O">Operative</option>
                                        </select>
                                    @else
                                        <!-- Text -->
                                        @if($med_history->disease_input_type == 'text_opt')
                                            @if($fvalue)
                                                <?php $dis = ""; ?>
                                            @else
                                                <?php $dis = "disabled='disabled'"; ?>
                                            @endif
                                            <input type="text" id="disease[{{ $med_history->disease_id }}]" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" value='{{ $fvalue }}' {{ $dis }} class="form-control col-md-3 control-box input-sm {{ str_slug($med_history->disease_code) }} notempty" />
                                        @else
                                            <input type="text" id="disease[{{ $med_history->disease_id }}]" name="disease[{{ $data[0]->disease_category }}][{{ $med_history->disease_id }}]" value='{{ $fvalue }}' class="form-control col-md-3 control-box input-sm" />
                                        @endif
                                    @endif
                                </dd>
                                </dl>
                                <?php } else { ?>
                                <p>-- no data found --</p>
                                <?php } ?>

                            <?php if($med_history->before_after > 0) {

                            ?>
                            <dl class="form-group col-md-{{ 6*($med_history->before_after) }}" style="height:55px;">
                            </dl>
                            <?php } ?>
                        {{--*/ $currIndex++; /*--}}

                    @endforeach
                </div>
            </fieldset>
          @endif

        <?php } ?>
    </div>
        <div class="form-group col-md-6">
            <fieldset>
            <legend style="font-size:18px;">Medical History Narrative</legend>
            <p>You can also type the Patient's Medical History in free form text.</p>
            <?php $thisnarrative = ""; ?>
            @if($pdat)
                @foreach($pdat as $c=>$a)
                    @if($a->disease_id == 'narrative')
                        <?php $thisnarrative = $a->disease_status; ?>
                    @endif
                @endforeach
            @endif
            <textarea class="form-control col-md-12 control-box" name="disease[Narrative][narrative]" rows="50">{{ $thisnarrative }}</textarea>
            </fieldset>
        </div>

        <br clear="all" />
</div>
