<?php
    function procDate($date) {
        if($date) {
            $d = date('m/d/Y', strtotime($date));
            return $d;
        } else {
            return NULL;
        }
    }
    $hservice_id = $allData['healthcareserviceid'];
    $fpservice_id = $data['pediatrics_id'];
    $patient_id = $allData['patient']->patient_id;
    $currentdate = date("m/d/Y");

    //if this is a follow-up
    //assign previous data
    if($pdata AND $data['pediatrics_id'] == NULL)
    {
        $data = $pdata;
    }

    if( isset($allData['pluginparentdata']) ) {
        $pediatricscase_id = $allData['pluginparentdata']->pediatricscase_id;
    } elseif($data->pediatricscase_id) {
        $pediatricscase_id = $data->pediatricscase_id;
    } else {
        $pediatricscase_id = NULL;
    }
?>

<!-- if there's pediatricstric background - make this uneditable proceed to Pediatricstric -->

{!! Form::hidden('pediatrics[fpservice_id]',$fpservice_id) !!}
{!! Form::hidden('pediatrics[patient_id]',$patient_id) !!}
{!! Form::hidden('pediatrics[hservice_id]',$hservice_id) !!}
{!! Form::hidden('pediatrics[pediatricscase_id]',$pediatricscase_id) !!}
    <div class="icheck">
        <fieldset>
            <legend>Date of Newborn Screening</legend>
            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Referral Date</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[newborn_screening_referral_date]" type="text" value="{{ procDate($data['newborn_screening_referral_date']) }}">
                    </div>
                </div>
                <label class="col-sm-2 control-label">Done</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[newborn_screening_actual_date]" type="text"  value="{{ procDate($data['newborn_screening_actual_date']) }}">
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Child Protected at Birth</legend>
            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Date Assessed</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[child_protection_date]" type="text"  value="{{ procDate($data['child_protection_date']) }}">
                    </div>
                </div>
                <label class="col-sm-2 control-label">TT Status</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control alphanumeric" placeholder="" name="pediatrics[tt_status]" value="{{ $data['tt_status'] or NULL }}"/>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Micronutrient Supplementation - Vitamin A</legend>
            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Date First Given</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[vit_a_supp_first_date]" type="text" value="{{ procDate($data['vit_a_supp_first_date']) }}">
                    </div>
                </div>
                <label class="col-sm-2 control-label">Age</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control alphanumeric" placeholder="Age" name="pediatrics[vit_a_first_age]" value="{{ $data['vit_a_first_age'] or NULL }}"/>
                </div>
                <label class="col-sm-1 control-label">months</label>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Date Second Given</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[vit_a_supp_second_date]" type="text" value="{{ procDate($data['vit_a_supp_second_date']) }}">
                    </div>
                </div>
                <label class="col-sm-2 control-label">Age</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control alphanumeric" placeholder="Age" name="pediatrics[vit_a_second_age]" value="{{ $data['vit_a_second_age'] or NULL }}"/>
                </div>
                <label class="col-sm-1 control-label">months</label>
            </div>
        </fieldset>
        <fieldset>
            <legend>Micronutrient Supplementation - Iron</legend>
            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Birth Weight</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control alphanumeric" placeholder="Weight" name="pediatrics[birth_weight]" value="{{ $data['birth_weight'] or NULL }}"/>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Date Started</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[iron_supp_start_date]" type="text" value="{{ procDate($data['iron_supp_start_date']) }}">
                    </div>
                </div>
                <label class="col-sm-2 control-label">Date Completed</label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[iron_supp_end_date]" type="text" value="{{ procDate($data['iron_supp_end_date']) }}">
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Recommended Immunization Date</legend>
            <div class="col-sm-12">
                <label class="col-sm-4"><center><strong>Immunization Type</strong></center></label>
                <label class="col-sm-4"><center><strong>Appointment Date</strong></center></label>
                <label class="col-sm-4"><center><strong>Actual Date</strong></center></label>
            </div>
            <div class="col-sm-12">
                <label class="col-sm-4 control-label">BCG</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[bcg_recommended_date]" type="text" value="{{ procDate($data['bcg_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[bcg_actual_date]" type="text" value="{{ procDate($data['bcg_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">Pentavalent 1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[penta1_recommended_date]" type="text" value="{{ procDate($data['penta1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[penta1_actual_date]" type="text" value="{{ procDate($data['penta1_actual_date']) }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="col-sm-4 control-label">Pentavalent 2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[penta2_recommended_date]" type="text" value="{{ procDate($data['penta2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[penta2_actual_date]" type="text" value="{{ procDate($data['penta2_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">Pentavalent 3</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[penta3_recommended_date]" type="text" value="{{ procDate($data['penta3_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[penta3_actual_date]" type="text" value="{{ procDate($data['penta3_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">Measles</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[measles_recommended_date]" type="text" value="{{ procDate($data['measles_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[measles_actual_date]" type="text" value="{{ procDate($data['measles_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">HEPA B1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[hepa_b1_recommended_date]" type="text" value="{{ procDate($data['hepa_b1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[hepa_b1_actual_date]" type="text" value="{{ procDate($data['hepa_b1_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">HEPA B2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[hepa_b2_recommended_date]" type="text" value="{{ procDate($data['hepa_b2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[hepa_b2_actual_date]" type="text" value="{{ procDate($data['hepa_b2_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">HEPA B3</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[hepa_b3_recommended_date]" type="text" value="{{ procDate($data['hepa_b3_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[hepa_b3_actual_date]" type="text" value="{{ procDate($data['hepa_b3_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">OPV1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[opv1_recommended_date]" type="text" value="{{ procDate($data['opv1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[opv1_actual_date]" type="text" value="{{ procDate($data['opv1_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">OPV2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[opv2_recommended_date]" type="text" value="{{ procDate($data['opv2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[opv2_actual_date]" type="text" value="{{ procDate($data['opv2_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">OPV3</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[opv3_recommended_date]" type="text" value="{{ procDate($data['opv3_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[opv3_actual_date]" type="text" value="{{ procDate($data['opv3_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">PCV 1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[pcv1_recommended_date]" type="text" value="{{ procDate($data['pcv1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[pcv1_actual_date]" type="text" value="{{ procDate($data['pcv1_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">PCV 2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[pcv2_recommended_date]" type="text" value="{{ procDate($data['pcv2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[pcv2_actual_date]" type="text" value="{{ procDate($data['pcv2_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">PCV 3</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[pcv3_recommended_date]" type="text" value="{{ procDate($data['pcv3_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[pcv3_actual_date]" type="text" value="{{ procDate($data['pcv3_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">MCV1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[mcv1_recommended_date]" type="text" value="{{ procDate($data['mcv1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[mcv1_actual_date]" type="text" value="{{ procDate($data['mcv1_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">MCV2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[mcv2_recommended_date]" type="text" value="{{ procDate($data['mcv2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[mcv2_actual_date]" type="text" value="{{ procDate($data['mcv2_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">ROTA1</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[rota1_recommended_date]" type="text" value="{{ procDate($data['rota1_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[rota1_actual_date]" type="text" value="{{ procDate($data['rota1_actual_date']) }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-4 control-label">ROTA2</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_future_null" id="datepicker_null" placeholder="Recommended Date" name="pediatrics[rota2_recommended_date]" type="text" value="{{ procDate($data['rota2_recommended_date']) }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" placeholder="Actual Date" name="pediatrics[rota2_actual_date]" type="text" value="{{ procDate($data['rota2_actual_date']) }}">
                    </div>
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>Child was Exclusively Breastfed</legend>
            <div class="col-sm-12">
                <label class="col-sm-2 control-label">First Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_first_month]" type="radio" value="1" <?php if($data['is_breastfed_first_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_first_month]" type="radio" value="0" <?php if($data['is_breastfed_first_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Second Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_second_month]" type="radio" value="1" <?php if($data['is_breastfed_second_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_second_month]" type="radio" value="0" <?php if($data['is_breastfed_second_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Third Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_third_month]" type="radio" value="1" <?php if($data['is_breastfed_third_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_third_month]" type="radio" value="0" <?php if($data['is_breastfed_third_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Fourth Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_fourth_month]" type="radio" value="1" <?php if($data['is_breastfed_fourth_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_fourth_month]" type="radio" value="0" <?php if($data['is_breastfed_fourth_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Fifth Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_fifth_month]" type="radio" value="1" <?php if($data['is_breastfed_sixth_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_fifth_month]" type="radio" value="0" <?php if($data['is_breastfed_sixth_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label class="col-sm-2 control-label">Sixth Month</label>
                <div class="col-sm-3">
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_sixth_month]" type="radio" value="1" <?php if($data['is_breastfed_sixth_month']=='1'){echo "checked";}?>>Yes
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input name="pediatrics[is_breastfed_sixth_month]" type="radio" value="0" <?php if($data['is_breastfed_sixth_month']=='0'){echo "checked";}?>> No
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control datepicker_null" id="" name="pediatrics[breastfeed_sixth_month]" type="text" placeholder="11/30/2000" value="{{ $data['breastfeed_sixth_month'] or NULL }}">

                    </div>
                </div>
            </div>
        </fieldset>

    </div>
