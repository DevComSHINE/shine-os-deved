<?php $ctr_FINDX = 0; ?>
<?php
if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }
$hide = 'hidden';
?>

<fieldset>
    <legend>Impressions and Diagnosis</legend>
        <div class="impressionDiagnosis col-sm-12">
            <table class="col-sm-12">
                <tbody class="appendHere">
                @if ($diagnosis_record != NULL)
                    @foreach($diagnosis_record as $krecord => $vrecord)
                        <tr class="impanddiag" id="added{{ $krecord }}">
                            <td class='col-sm-11'>
                                {!! Form::hidden('impanddiag[update][diagnosis_id][]', $vrecord->diagnosis_id) !!}
                                <table class="col-sm-12">
                                    <tr>
                                        <td class='col-sm-2' valign="top"> <label class="control-label"> Diagnosis Type </label> </td>
                                        <td class='col-sm-8'>

                                            {!! Form::select('impanddiag[update][type][]',
                                            array(
                                                '' => 'Choose Type',
                                                'ADMDX' => 'Admitting diagnosis',
                                                'CLIDI' => 'Clinical diagnosis',
                                                'WODIA' => 'Working Diagnosis',
                                                'FINDX' => 'Final Diagnosis',
                                            ), $vrecord->diagnosis_type,
                                         ['class' => 'required form-control', 'id'=> 'diagnosisType', 'required'=>'required', $read]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis </label> </td>
                                       <td class='col-sm-8'>
                                           @if($vrecord->diagnosislist_id == 'Other')
                                                <?php $diaglist = $vrecord->diagnosislist_other; ?>
                                           @else
                                                <?php $diaglist = $vrecord->diagnosislist_id; ?>
                                           @endif
                                           {!! Form::textarea('impanddiag[update][diagnosislist_id][]', $diaglist, ['class' => 'form-control noresize diagnosis_input required', 'placeholder' => 'Diagnosis', 'id'=>'diagnosis_input'.$krecord, 'rows'=>'3', 'required'=>'required', $read]) !!}
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Notes </label> </td>
                                       <td class='col-sm-8'>
                                            {!! Form::textarea('impanddiag[update][notes][]', $vrecord->diagnosis_notes, ['class' => 'form-control noresize', 'placeholder' => 'Diagnosis notes', 'cols'=>'10', 'rows'=>'5', $read]) !!}
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <legend></legend> </td>
                                    </tr>
                                </table>
                            </td>
                            <td class='col-sm-1'>
                                @if($krecord > 0)
                                <button type="button" class="deleteRow btn btn-danger">
                                @else
                                <button type="button" class="deleteRow btn btn-danger hidden">
                                @endif
                                    <i class="fa fa-trash-o"></i> Remove </button>

                            </td>
                        </tr>
                        @if($vrecord->diagnosis_type=='FINDX')
                            <?php $ctr_FINDX = 1; ?>
                        @endif
                    @endforeach
                @else
                    <?php $krecord = 0; ?>
                    <tr class="impanddiag" id="added{{ $krecord }}">
                            <td class='col-sm-10'>
                                {!! Form::hidden('impanddiag[insert][diagnosis_id][]', '') !!}
                                <table class="col-sm-12">
                                    <tr>
                                        <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Type </label> </td>
                                        <td class='col-sm-8'>
                                            {!! Form::select('impanddiag[insert][type][]',
                                            array(
                                                '' => 'Choose Type',
                                                'ADMDX' => 'Admitting diagnosis',
                                                'CLIDI' => 'Clinical diagnosis',
                                                'WODIA' => 'Working Diagnosis',
                                                'FINDX' => 'Final Diagnosis',
                                            ), '',
                                         ['class' => 'form-control required', 'id'=> 'diagnosisType', 'required'=>'required', $read]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis </label> </td>
                                       <td class='col-sm-8'>
                                           {!! Form::textarea('impanddiag[insert][diagnosislist_id][]', null, ['class' => 'form-control noresize diagnosis_input required', 'placeholder' => 'Diagnosis', 'id'=>'diagnosis_input'.$krecord, 'rows'=>'3', 'required'=>'required', $read]) !!}
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Notes </label> </td>
                                       <td class='col-sm-8'>
                                            {!! Form::textarea('impanddiag[insert][notes][]', '', ['class' => 'form-control noresize', 'placeholder' => 'Diagnosis notes', 'cols'=>'10', 'rows'=>'5', $read]) !!}
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <legend></legend> </td>
                                    </tr>
                                </table>
                            </td>
                            <td class='col-sm-1'>
                                @if($krecord > 0)
                                    <button type="button" class="deleteRow btn btn-danger">
                                @else
                                    <button type="button" class="deleteRow btn btn-danger hidden">
                                @endif
                                <i class="fa fa-trash-o"></i> Remove </button>
                            </td>
                        </tr>
                @endif

                </tbody>
            </table>

            @if(empty($disposition_record->disposition))
                @if($ctr_FINDX != 1)
                    <div class="col-sm-12">
                        <button type="button" class="addRow btn btn-success"><i class="fa fa-plus-circle"></i> Add More</button>
                    </div><!-- box-footer -->
                @endif
            @endif
        </div>
</fieldset>

@if(isset($vrecord->diagnosis_type) AND $vrecord->diagnosis_type=='FINDX')
    @foreach($diagnosis_record as $kdiag => $vdiag)
       @if(empty($vdiag->diagnosis_i_c_d10) == FALSE)
            {!! Form::hidden('impanddiag[ctr_diagnosis_i_c_d10]', '1') !!}
            <fieldset>
                <legend>ICD10 Final Diagnosis</legend>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 Classifications </label>
                    <div class="col-sm-8">
                        @if(isset($vdiag->diagnosis_i_c_d10[0]))
                        {!! Form::select('impanddiag[parent]', $icd10,
                            (empty($vdiag->diagnosis_i_c_d10[0]->icd10_classifications) ? 'I' : $vdiag->diagnosis_i_c_d10[0]->icd10_classifications),
                            ['class' => 'form-control', 'id' => 'diag_parent', $read]
                        ); !!}
                        @else
                        {!! Form::select('impanddiag[parent]', $icd10,
                            null,
                            ['class' => 'form-control', 'id' => 'diag_parent', $read]
                        ); !!}
                        @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 Sub-Classification </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="diag_cat" name="impanddiag[category]" <?php echo $read; ?>>
                            @if(isset($vdiag->diagnosis_i_c_d10[0]) AND $vdiag->diagnosis_i_c_d10[0]->icd10_subClassifications != NULL AND isset($icd10_sub[$vdiag->diagnosis_i_c_d10[0]->icd10_subClassifications]) )
                                <option value="{{ $vdiag->diagnosis_i_c_d10[0]->icd10_subClassifications }}" selected> {{ $icd10_sub[$vdiag->diagnosis_i_c_d10[0]->icd10_subClassifications] }}</option>
                            @else
                                <option value="" selected> </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 Disease Type </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="diag_subcat" name="impanddiag[subcat]" <?php echo $read; ?>>
                            @if(isset($vdiag->diagnosis_i_c_d10[0]) AND $vdiag->diagnosis_i_c_d10[0]->icd10_type != NULL AND isset($icd10_type[$vdiag->diagnosis_i_c_d10[0]->icd10_type]) )
                                <option value="{{ $vdiag->diagnosis_i_c_d10[0]->icd10_type }}" selected> {{ $icd10_type[$vdiag->diagnosis_i_c_d10[0]->icd10_type] }}</option>
                            @else
                                <option value="" selected> </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 CODE </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="diag_subsubcat" name="impanddiag[subsubcat]" <?php echo $read; ?>>
                            @if(isset($vdiag->diagnosis_i_c_d10[0]) AND $vdiag->diagnosis_i_c_d10[0]->icd10_code != NULL AND isset($icd10_code[$vdiag->diagnosis_i_c_d10[0]->icd10_code]) )
                                <option value="{{ $vdiag->diagnosis_i_c_d10[0]->icd10_code }}" selected> {{ $icd10_code[$vdiag->diagnosis_i_c_d10[0]->icd10_code] }}</option>
                            @else
                                <option value="" selected> </option>
                            @endif
                        </select>
                    </div>
                </div>
            </fieldset>
        @else
            {!! Form::hidden('impanddiag[ctr_diagnosis_i_c_d10]', '0') !!}
            <?php $hide = ''; ?>
        @endif
    @endforeach
@else
    {!! Form::hidden('impanddiag[ctr_diagnosis_i_c_d10]', '0') !!}
@endif

<fieldset id="FinalDiagnosis" class="{{ $hide }}">
    <legend>ICD10 Final Diagnosis</legend>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Classifications </label>
        <div class="col-sm-8">
            {!! Form::select('impanddiag[parent]', $icd10, '0', ['class' => 'form-control', 'id' => 'diag_parent', $read] ); !!}
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Sub-Classification </label>
        <div class="col-sm-8">
        <!-- icd10_type     icd10_code -->
            <select class="form-control" id="diag_cat" name="impanddiag[category]" <?php echo $read; ?>>
                <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Disease Type </label>
        <div class="col-sm-8">
            <select class="form-control" id="diag_subcat" name="impanddiag[subcat]" <?php echo $read; ?>>
                    <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 CODE </label>
        <div class="col-sm-8">
            <select class="form-control" id="diag_subsubcat" name="impanddiag[subsubcat]" <?php echo $read; ?>>
                    <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
</fieldset>

<br clear="all" />

<script>
    //setup autocomplete for diagnosis
    var availableTags = [
        <?php foreach($lovdiagnosis as $diag) { ?>
        "<?php echo $diag->diagnosis_name; ?>",
        <?php } ?>
    ];
</script>
