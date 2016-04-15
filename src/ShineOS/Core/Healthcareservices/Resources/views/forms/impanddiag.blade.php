{!! Form::open(array('route' => 'imp.insert')) !!}

<?php $ctr_FINDX = 0; ?>
{!! Form::hidden('healthcareservice_id', $healthcareserviceid) !!}

<?php
if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }
?>

<fieldset>
    <legend>Impressions and Diagnosis</legend>
        <div class="impressionDiagnosis col-sm-12">
            <table class="col-sm-12">
                <tbody class="appendHere">
                @if ($diagnosis_record != NULL)
                    @foreach($diagnosis_record as $krecord => $vrecord)
                        <tr class="impanddiag">
                            <td class='col-sm-11'>
                                {!! Form::hidden('diag[update][diagnosis_id][]', $vrecord->diagnosis_id) !!}
                                <table class="col-sm-12">
                                    <tr>
                                        <td class='col-sm-2' valign="top"> <label class="control-label"> Diagnosis Type </label> </td>
                                        <td class='col-sm-8'>
                                            {!! Form::select('diag[update][type][]',
                                            array(
                                                'ADMDX' => 'Admitting diagnosis',
                                                'CLIDI' => 'Clinical diagnosis',
                                                'FINDX' => 'Final Diagnosis',
                                                'OTHER' => 'Other Diagnosis',
                                                'WODIA' => 'Working Diagnosis',
                                                'WORDX' => 'Interim Diagnosis',
                                            ), $vrecord->diagnosis_type,
                                         ['class' => 'form-control', 'id'=> 'diagnosisType', $read]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis </label> </td>
                                       <td class='col-sm-8'>
                                           <textarea id="diagnosis_input{{ $krecord }}" class="form-control diagnosis_input" rows="3" name="diag[update][diagnosislist_id][]"><?php echo $vrecord->diagnosislist_id; ?></textarea>

                                       </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Notes </label> </td>
                                       <td class='col-sm-8'>
                                            {!! Form::textarea('diag[update][notes][]', $vrecord->diagnosis_notes, ['class' => 'form-control noresize', 'placeholder' => 'Diagnosis notes', 'cols'=>'10', 'rows'=>'5', $read]) !!}
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
                    <tr class="impanddiag">
                            <td class='col-sm-10'>
                                {!! Form::hidden('diag[insert][diagnosis_id][]', '') !!}
                                <table class="col-sm-12">
                                    <tr>
                                        <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Type </label> </td>
                                        <td class='col-sm-8'>
                                            {!! Form::select('diag[insert][type][]',
                                            array(
                                                'ADMDX' => 'Admitting diagnosis',
                                                'CLIDI' => 'Clinical diagnosis',
                                                'FINDX' => 'Final Diagnosis',
                                                'OTHER' => 'Other Diagnosis',
                                                'WODIA' => 'Working Diagnosis',
                                                'WORDX' => 'Interim Diagnosis',
                                            ), '',
                                         ['class' => 'form-control', 'id'=> 'diagnosisType', $read]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis </label> </td>
                                       <td class='col-sm-8'>
                                           <textarea id="diagnosis_input{{ $krecord }}" class="form-control diagnosis_input" rows="3" name="diag[insert][diagnosislist_id][]"></textarea>

                                       </td>
                                    </tr>
                                    <tr>
                                       <td class='col-sm-3' valign="top"> <label class="control-label"> Diagnosis Notes </label> </td>
                                       <td class='col-sm-8'>
                                            {!! Form::textarea('diag[insert][notes][]', '', ['class' => 'form-control noresize', 'placeholder' => 'Diagnosis notes', 'cols'=>'10', 'rows'=>'5', $read]) !!}
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


            @if(empty($disposition_record))
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
            {!! Form::hidden('ctr_diagnosis_i_c_d10', '1') !!}
            <fieldset>
                <legend>ICD10 Final Diagnosis</legend>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 Classifications </label>
                    <div class="col-sm-8">
                        {!! Form::select('parent', $icd10,
                                            (empty($vdiag->diagnosis_i_c_d10[0]->icd10_classifications) ? 'I' : $vdiag->diagnosis_i_c_d10[0]->icd10_classifications),
                                            ['class' => 'form-control', 'id' => 'diag_parent', $read]
                        ); !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-3 control-label"> ICD10 Sub-Classification </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="diag_cat" name="category" <?php echo $read; ?>>
                            @if($vdiag->diagnosis_i_c_d10[0]->icd10_subClassifications != '0')
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
                        <select class="form-control" id="diag_subcat" name="subcat" <?php echo $read; ?>>
                            @if($vdiag->diagnosis_i_c_d10[0]->icd10_type != '0')
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
                        <select class="form-control" id="diag_subsubcat" name="subsubcat"<?php echo $read; ?>>
                            @if($vdiag->diagnosis_i_c_d10[0]->icd10_code != '0')
                                <option value="{{ $vdiag->diagnosis_i_c_d10[0]->icd10_code }}" selected> {{ $icd10_code[$vdiag->diagnosis_i_c_d10[0]->icd10_code] }}</option>
                            @else
                                <option value="" selected> </option>
                            @endif
                        </select>
                    </div>
                </div>
            </fieldset>
        @else
            {!! Form::hidden('ctr_diagnosis_i_c_d10', '0') !!}
        @endif
    @endforeach
@else
    {!! Form::hidden('ctr_diagnosis_i_c_d10', '0') !!}
@endif

<fieldset id="FinalDiagnosis" class="hidden">
    <legend>ICD10 Final Diagnosis</legend>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Classifications </label>
        <div class="col-sm-8">
            {!! Form::select('parent', $icd10, 'XX', ['class' => 'form-control', 'id' => 'diag_parent', $read] ); !!}
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Sub-Classification </label>
        <div class="col-sm-8">
        <!-- icd10_type     icd10_code -->
            <select class="form-control" id="diag_cat" name="category" <?php echo $read; ?>>
                <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 Disease Type </label>
        <div class="col-sm-8">
            <select class="form-control" id="diag_subcat" name="subcat" <?php echo $read; ?>>
                    <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <label class="col-sm-3 control-label"> ICD10 CODE </label>
        <div class="col-sm-8">
            <select class="form-control" id="diag_subsubcat" name="subsubcat" <?php echo $read; ?>>
                    <option value="" disabled selected>-- Select --</option>
            </select>
        </div>
    </div>
</fieldset>
@if(empty($disposition_record->disposition))
<fieldset>
    <div class="form-group">
        <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary pull-right">Save Impressions and Diagnosis</button>
            </div>
        </div>
    </div>
</fieldset>
@endif
{!! Form::close() !!}

<script>
    //setup autocomplete for diagnosis
    var availableTags = [
        <?php foreach($lovdiagnosis as $diag) { ?>
        "<?php echo $diag->diagnosis_name; ?>",
        <?php } ?>
    ];
</script>
