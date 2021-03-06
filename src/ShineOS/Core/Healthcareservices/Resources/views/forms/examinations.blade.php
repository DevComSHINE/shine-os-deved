{!! Form::hidden('examinations[examination_id]', isset($examinations_record) ? $examinations_record->examination_id : NULL) !!}

<?php
if(empty($disposition_record->disposition)) { $read = ''; }
else { $read = 'disabled'; }
?>
<div class="icheck rosystems">
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>Skin</legend>
        <div class="col-md-12 margin-bottom noPadding">
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Pallor</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                        {!! Form::checkbox("examinations[anatomy][Pallor]", 1, (isset($examinations_record) ? (($examinations_record->Pallor==1) ? true : '') : false), [$read]); !!} Yes
                    </label>

                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Rashes</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Rashes]", 1, (isset($examinations_record) ? (($examinations_record->Rashes==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Jaundice</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Jaundice]", 1, (isset($examinations_record) ? (($examinations_record->Jaundice==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Good Skin Turgor</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Good_Skin_Turgor]", 1, (isset($examinations_record) ? (($examinations_record->Good_Skin_Turgor==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                    </dd>
            </dl>


            <dl>
                <dt class="col-sm-5"> <label class="control-label">Others</label> </dt>
                <dd>
                    {!! Form::text("examinations[anatomy][skin_others]", (isset($examinations_record) ? (($examinations_record->skin_others) ? $examinations_record->skin_others : null) : null), ['class' => 'form-control alpha cotrol-box input-sm', $read]) !!}
                </dd>
            </dl>
        </div>
    </fieldset>
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>HEENT</legend>
        <div class="col-md-12 margin-bottom noPadding">
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Anicteric Sclerae</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Anicteric_Sclerae]", 1, (isset($examinations_record) ? (($examinations_record->Anicteric_Sclerae==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Pupils</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Pupils]", 1, (isset($examinations_record) ? (($examinations_record->Pupils==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Aural Discharge </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Aural_Discharge]", 1, (isset($examinations_record) ? (($examinations_record->Aural_Discharge==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Intact Tympanic Membrane</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Intact_Tympanic_Membrane]", 1, (isset($examinations_record) ? (($examinations_record->Intact_Tympanic_Membrane==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <!--<dl>
                <dt class="col-sm-7"> <label class="control-label">Alar Flaring</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                          <input type="radio" name="examinations[anatomy][AlarFlaring]" id="" value="1" checked=""> Yes
                        </label>
                </dd>
            </dl>-->
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Nasal Discharge</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Nasal_Discharge]", 1, (isset($examinations_record) ? (($examinations_record->Nasal_Discharge==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Tonsillopharyngeal Congestion</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Tonsillopharyngeal_Congestion]", 1, (isset($examinations_record) ? (($examinations_record->Tonsillopharyngeal_Congestion==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Hypertrophic Tonsils</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Hypertrophic_Tonsils]", 1, (isset($examinations_record) ? (($examinations_record->Hypertrophic_Tonsils==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Palpable Mass</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Palpable_Mass_B]", 1, (isset($examinations_record) ? (($examinations_record->Palpable_Mass_B==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-7"> <label class="control-label">Exudates</label> </dt>
                <dd class="btn-group col-sm-5">
                    <label>
                            {!! Form::checkbox("examinations[anatomy][Exudates]", 1, (isset($examinations_record) ? (($examinations_record->Exudates==1) ? true : '') : false), [$read]); !!} Yes
                        </label>
                </dd>
            </dl>
            <dl>
                <dt class="col-sm-5"> <label class="control-label">Others</label> </dt>
                <dd>
                    {!! Form::text("examinations[anatomy][heent_others]", (isset($examinations_record) ? (($examinations_record->heent_others) ? $examinations_record->heent_others : null) : null), ['class' => 'form-control alpha cotrol-box input-sm', $read]) !!}
                </dd>
            </dl>
        </div>
    </fieldset>
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>Chest/Lungs</legend>
            <div class="col-md-12 margin-bottom noPadding">
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Symmetrical Chest Expansion</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Symmetrical_Chest_Expansion]", 1, (isset($examinations_record) ? (($examinations_record->Symmetrical_Chest_Expansion==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Clear Breathsounds</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Clear_Breathsounds]", 1, (isset($examinations_record) ? (($examinations_record->Clear_Breathsounds==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <!--<dl>
                    <dt class="col-sm-5"> <label class="control-label">Retractions</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                              <input type="radio" name="examinations[anatomy][Retractions]" id="" value="1" checked=""> Yes
                            </label>
                    </dd>
                </dl>-->
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Crackles Rales</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Crackles_Rales]", 1, (isset($examinations_record) ? (($examinations_record->Crackles_Rales==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Wheezes</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Wheezes]", 1, (isset($examinations_record) ? (($examinations_record->Wheezes==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-5"> <label class="control-label">Others</label> </dt>
                    <dd>
                        {!! Form::text('anatomy_chest_others', (isset($examinations_record) ? (($examinations_record->chest_others) ? $examinations_record->chest_others : null) : null), array('class' => 'control-box input-sm form-control ', 'name'=>'examinations[anatomy][chest_others]', $read) ) !!}
                  <!--       <input class="form-control cotrol-box input-sm" type="text" placeholder="" name="examinations[anatomy][chest_Others"> -->
                    </dd>
                </dl>
            </div>
    </fieldset>
    <br clear="all" />
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>Heart</legend>
            <div class="col-sm-12 margin-bottom">
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Adynamic Precordium</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Adynamic_Precordium]", 1, (isset($examinations_record) ? (($examinations_record->Adynamic_Precordium==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Rhythm</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Rhythm]", 1, (isset($examinations_record) ? (($examinations_record->Rhythm==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Heaves</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Heaves]", 1, (isset($examinations_record) ? (($examinations_record->Heaves==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Murmurs</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Murmurs]", 1, (isset($examinations_record) ? (($examinations_record->Murmurs==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Others</label> </dt>
                    <dd>
                        {!! Form::text('anatomy_chest_others', (isset($examinations_record) ? (($examinations_record->heart_others) ? $examinations_record->heart_others : null) : null), array('class' => 'control-box input-sm form-control ', 'name'=>'examinations[anatomy][heart_others]', $read) ) !!}
                    </dd>
                </dl>
            </div>
    </fieldset>
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>Abdomen</legend>
            <div class="col-md-12 margin-bottom noPadding">
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Flat</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Flat]", 1, (isset($examinations_record) ? (($examinations_record->Flat==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Globular</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Globular]", 1, (isset($examinations_record) ? (($examinations_record->Globular==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Flabby</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Flabby]", 1, (isset($examinations_record) ? (($examinations_record->Flabby==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Muscle Guarding</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Muscle_Guarding]", 1, (isset($examinations_record) ? (($examinations_record->Muscle_Guarding==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Tenderness</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Tenderness]", 1, (isset($examinations_record) ? (($examinations_record->Tenderness==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Palpable Mass</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Palpable_Mass_B]", 1, (isset($examinations_record) ? (($examinations_record->Palpable_Mass_B==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-5"> <label class="control-label">Others</label> </dt>
                    <dd>
                        {!! Form::text('anatomy_abdomen_others', (isset($examinations_record) ? (($examinations_record->abdomen_others) ? $examinations_record->abdomen_others : null) : null), array('class' => 'control-box input-sm form-control ', 'name'=>'examinations[anatomy][abdomen_others]', $read) ) !!}
                    </dd>
                </dl>
            </div>
    </fieldset>
    <fieldset {{$disabled}} class="col-sm-4">
        <legend>Extremities</legend>
            <div class="col-md-12 margin-bottom noPadding">
                <!---<dl>
                    <dt class="col-sm-7"> <label class="control-label">Gross Deformity</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                              <input type="radio" name="examinations[anatomy][Gross_Deformity]" id="" value="1" checked=""> Yes
                            </label>
                    </dd>
                </dl>-->
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Normal Gait</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Normal_Gait]", 1, (isset($examinations_record) ? (($examinations_record->Normal_Gait==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-7"> <label class="control-label">Full Equal Pulses</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox("examinations[anatomy][Full_Equal_Pulses]", 1, (isset($examinations_record) ? (($examinations_record->Full_Equal_Pulses==1) ? true : '') : false), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl>
                    <dt class="col-sm-5"> <label class="control-label">Others</label> </dt>
                    <dd>
                        {!! Form::text('anatomy_extreme_others', (isset($examinations_record) ? (($examinations_record->extreme_others) ? $examinations_record->extreme_others : null) : null), array('class' => 'control-box input-sm form-control ', 'name'=>'examinations[anatomy][extreme_others]', $read) ) !!}
                        <!-- <input class="form-control cotrol-box input-sm" type="text" name="examinations[anatomy][extreme_Others]"> -->
                    </dd>
                </dl>
            </div>
    </fieldset>

    <br clear="all" />

</div>
